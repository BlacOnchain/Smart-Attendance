<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Course;
use App\Models\Timetable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    private const TOKEN_FRESHNESS_SECONDS = 1800;

    // 1. Show Lecturer Dashboard — Scoped overview & active session tools
    public function lecturerDashboard()
    {
        $user = Auth::user();

        $myCourses = Course::where('lecturer_id', $user->id)->orderBy('course_code')->get();
        $myCourseCodes = $myCourses->pluck('course_code');

        $sessions = AttendanceSession::whereIn('course_code', $myCourseCodes)
            ->with('attendances.user')
            ->withCount('attendances')
            ->latest()
            ->get();

        $activeSession = AttendanceSession::where('is_active', true)
            ->whereIn('course_code', $myCourseCodes)
            ->latest()
            ->first();

        $sessionIds = $sessions->pluck('id');

        $totalSessions = $sessions->count();
        $totalCheckIns = Attendance::whereIn('attendance_session_id', $sessionIds)->count();
        $todayCheckIns = Attendance::whereIn('attendance_session_id', $sessionIds)
            ->whereDate('created_at', today())
            ->count();
        $activeSessionsCount = $sessions->where('is_active', true)->count();

        $recentAttendances = Attendance::with('user', 'session')
            ->whereIn('attendance_session_id', $sessionIds)
            ->latest()
            ->take(8)
            ->get();

        return view('lecturer.dashboard', compact(
            'sessions',
            'activeSession',
            'totalSessions',
            'totalCheckIns',
            'todayCheckIns',
            'activeSessionsCount',
            'recentAttendances',
            'myCourses'
        ) + [
            'tokenFreshnessSeconds' => self::TOKEN_FRESHNESS_SECONDS,
        ]);
    }

    // 2. Dedicated Students Attendance Summary Page
    public function studentsView()
    {
        $user = Auth::user();
        $myCourseCodes = Course::where('lecturer_id', $user->id)->pluck('course_code');
        $sessionIds = AttendanceSession::whereIn('course_code', $myCourseCodes)->pluck('id');

        $studentAttendanceCounts = Attendance::with('user')
            ->whereIn('attendance_session_id', $sessionIds)
            ->get()
            ->filter(fn ($attendance) => $attendance->user !== null)
            ->groupBy('user_id')
            ->map(function ($group) {
                return (object) [
                    'user' => $group->first()->user,
                    'count' => $group->count(),
                    'last_checked_in' => $group->max('scanned_at'),
                ];
            })
            ->sortByDesc('count')
            ->values();

        return view('lecturer.students', compact('studentAttendanceCounts'));
    }

    // 3. Dedicated My Courses & Course Claiming Page
    public function coursesView()
    {
        $user = Auth::user();
        $myCourses = Course::where('lecturer_id', $user->id)->orderBy('course_code')->get();
        $unclaimedCourses = Course::whereNull('lecturer_id')->orderBy('course_code')->get();

        return view('lecturer.courses', compact('myCourses', 'unclaimedCourses'));
    }

    // Initialize a new tracking session
    public function startSession(Request $request)
    {
        $request->validate([
            'course_code' => 'required|string|max:50|exists:courses,course_code',
        ]);

        $courseCode = strtoupper(trim($request->course_code));
        $course = Course::where('course_code', $courseCode)->first();

        if (!$course || $course->lecturer_id !== Auth::id()) {
            abort(403, 'You can only start sessions for courses assigned to you.');
        }

        AttendanceSession::create([
            'course_code' => $courseCode,
            'session_token' => Str::random(40),
            'token_generated_at' => now(),
            'is_active' => true,
            'lecturer_id' => Auth::id(),
        ]);

        return redirect()->route('lecturer.dashboard')->with('success', 'Attendance session started!');
    }

    // Claim an unassigned course
    public function claimCourse($id)
    {
        $course = Course::findOrFail($id);

        if ($course->lecturer_id) {
            return back()->withErrors(['course' => 'That course is already assigned to a lecturer.']);
        }

        $course->update(['lecturer_id' => Auth::id()]);

        return redirect()->route('lecturer.courses')->with('success', "You're now assigned to {$course->course_code}.");
    }

    public function showScanPage($token)
    {
        $session = AttendanceSession::where('session_token', $token)
            ->where('is_active', true)
            ->firstOrFail();

        $expired = $this->isTokenExpired($session);

        return view('scan_page', [
            'session' => $session,
            'token' => $token,
            'expired' => $expired,
            'tokenFreshnessSeconds' => self::TOKEN_FRESHNESS_SECONDS,
        ]);
    }

    public function logAttendance(Request $request, $token)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Please sign in first.'], 401);
        }

        $session = AttendanceSession::where('session_token', $token)
            ->where('is_active', true)
            ->first();

        if (!$session) {
            return response()->json([
                'message' => 'This QR code is no longer active. Ask your lecturer for the current code.',
            ], 404);
        }

        if ($this->isTokenExpired($session)) {
            return response()->json([
                'message' => 'This QR code has expired. Please scan the current code on your lecturer\'s screen.',
            ], 410);
        }

        $currentTime = now()->format('H:i:s');
        $currentDay = now()->format('l');

        $schedule = Timetable::where('course_code', $session->course_code)
            ->where('day_of_week', $currentDay)
            ->first();

        if ($schedule) {
            $startsAt = $schedule->start_time;
            $endsAt = $schedule->end_time;

            if ($currentTime < $startsAt || $currentTime > $endsAt) {
                $session->update(['is_active' => false]);

                return response()->json(['message' => 'Lecture period has ended.'], 403);
            }
        }

        $userId = Auth::id();

        $alreadyLogged = Attendance::where('attendance_session_id', $session->id)
            ->where('user_id', $userId)
            ->exists();

        if ($alreadyLogged) {
            return response()->json(['message' => 'Already checked in.'], 409);
        }

        try {
            Attendance::create([
                'attendance_session_id' => $session->id,
                'user_id' => $userId,
                'scanned_at' => now(),
            ]);
        } catch (QueryException $e) {
            if ($this->isDuplicateKeyError($e)) {
                return response()->json(['message' => 'Already checked in.'], 409);
            }

            throw $e;
        }

        return response()->json(['message' => 'Attendance logged successfully!']);
    }

    public function rotateToken($id)
    {
        $session = AttendanceSession::where('id', $id)->where('is_active', true)->firstOrFail();
        $this->authorizeSessionOwner($session);

        $session->update([
            'session_token' => Str::random(40),
            'token_generated_at' => now(),
        ]);

        return response()->json([
            'new_token' => $session->session_token,
            'new_url' => route('student.scan', $session->session_token),
            'expires_in' => self::TOKEN_FRESHNESS_SECONDS,
        ]);
    }

    public function closeSession($id)
    {
        $session = AttendanceSession::where('id', $id)->where('is_active', true)->first();

        if (!$session) {
            return redirect()->route('lecturer.dashboard')->with('error', 'This session is already closed or does not exist.');
        }

        $this->authorizeSessionOwner($session);
        $session->update(['is_active' => false]);

        return redirect()->route('lecturer.dashboard')->with('success', 'Session closed successfully.');
    }

    private function authorizeSessionOwner(AttendanceSession $session): void
    {
        if ($session->lecturer_id !== Auth::id()) {
            abort(403, 'You can only manage sessions you started.');
        }
    }

    private function isTokenExpired(AttendanceSession $session): bool
    {
        if (!$session->token_generated_at) {
            return true;
        }

        return $session->token_generated_at->diffInSeconds(now()) > self::TOKEN_FRESHNESS_SECONDS;
    }

    private function isDuplicateKeyError(QueryException $e): bool
    {
        $sqlState = $e->errorInfo[0] ?? null;
        $driverCode = $e->errorInfo[1] ?? null;

        return $driverCode == 1062
            || $sqlState === '23505'
            || str_contains($e->getMessage(), 'UNIQUE constraint failed');
    }
}