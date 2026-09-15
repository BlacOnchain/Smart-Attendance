<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class HodController extends Controller
{
    private function ensureHod(): void
    {
        abort_unless(auth()->check() && auth()->user()->is_hod, 403, 'HOD access is required.');
    }

    public function dashboard()
    {
        $this->ensureHod();

        $sessions = AttendanceSession::query();

        return view('hod.dashboard', [
            'studentCount' => User::where('role', 'student')->count(),
            'lecturerCount' => User::where('role', 'lecturer')->count(),
            'courseCount' => Course::count(),
            'sessionCount' => (clone $sessions)->count(),
            'todayAttendance' => Attendance::whereDate('created_at', today())->count(),
            'recentSessions' => (clone $sessions)->with('lecturer')->withCount('attendances')->latest()->take(8)->get(),
        ]);
    }

    public function reports(Request $request)
    {
        $this->ensureHod();

        $filters = $request->validate([
            'level' => ['nullable', 'string', 'max:20'],
            'course_code' => ['nullable', 'string', 'max:50'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $sessionQuery = AttendanceSession::query();
        if (! empty($filters['course_code'])) {
            $sessionQuery->where('course_code', strtoupper(trim($filters['course_code'])));
        }
        if (! empty($filters['date_from'])) {
            $sessionQuery->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (! empty($filters['date_to'])) {
            $sessionQuery->whereDate('created_at', '<=', $filters['date_to']);
        }

        $sessions = $sessionQuery->get();
        $sessionIds = $sessions->pluck('id');

        $attendanceRows = Attendance::with(['user', 'session'])
            ->whereIn('attendance_session_id', $sessionIds)
            ->get();

        $courseReports = $sessions->groupBy('course_code')->map(function ($courseSessions, $courseCode) use ($attendanceRows) {
            $ids = $courseSessions->pluck('id');
            $checkIns = $attendanceRows->whereIn('attendance_session_id', $ids)->count();
            $students = $attendanceRows->whereIn('attendance_session_id', $ids)->pluck('user_id')->unique()->count();

            return (object) [
                'course_code' => $courseCode,
                'sessions' => $courseSessions->count(),
                'check_ins' => $checkIns,
                'students' => $students,
                'average' => $students > 0 ? round(($checkIns / ($students * $courseSessions->count())) * 100, 1) : 0,
            ];
        })->sortBy('course_code')->values();

        $studentReports = $attendanceRows->groupBy('user_id')->map(function ($studentRows) use ($sessions) {
            $student = $studentRows->first()->user;
            $totalSessions = $sessions->filter(fn ($session) => ! $student || ! $student->level || ! $session->course_code)->count();
            $attended = $studentRows->count();

            return (object) [
                'name' => $student?->name ?? 'Unknown student',
                'email' => $student?->email ?? '',
                'level' => $student?->level ?? 'Not set',
                'attended' => $attended,
                'percentage' => $totalSessions > 0 ? round(($attended / $totalSessions) * 100, 1) : 0,
            ];
        })->sortByDesc('percentage')->values();

        if (! empty($filters['level'])) {
            $studentReports = $studentReports->where('level', $filters['level'])->values();
        }

        return view('hod.reports', compact('filters', 'courseReports', 'studentReports'));
    }

    public function exportReports(Request $request)
    {
        $this->ensureHod();

        $request->merge(['format' => 'csv']);
        $filters = $request->validate([
            'course_code' => ['nullable', 'string', 'max:50'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $query = Attendance::with(['user', 'session']);
        if (! empty($filters['course_code'])) {
            $query->whereHas('session', fn ($q) => $q->where('course_code', strtoupper(trim($filters['course_code']))));
        }
        if (! empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (! empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        $rows = $query->latest()->get();

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Student', 'Email', 'Level', 'Course', 'Checked in at']);
            foreach ($rows as $attendance) {
                fputcsv($handle, [
                    $attendance->user?->name ?? 'Unknown',
                    $attendance->user?->email ?? '',
                    $attendance->user?->level ?? '',
                    $attendance->session?->course_code ?? '',
                    optional($attendance->scanned_at)->toDateTimeString(),
                ]);
            }
            fclose($handle);
        }, 'attendance-report-' . now()->format('Y-m-d') . '.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}
