<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSession;
use App\Models\Course;
use App\Models\Attendance;
use App\Models\LoginActivity;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    private const LEVEL_OPTIONS = [
        '100' => 'ND1',
        '200' => 'ND2',
        '300' => 'HND1',
        '400' => 'HND2',
    ];

    private const LEVEL_MAP = [
        'ND1' => '100', '100' => '100',
        'ND2' => '200', '200' => '200',
        'HND1' => '300', '300' => '300',
        'HND2' => '400', '400' => '400',
    ];

    private function levelOptions(): array
    {
        return self::LEVEL_OPTIONS;
    }

    private function levelLabel(?string $level): string
    {
        return self::LEVEL_OPTIONS[$level]
            ?? ($level ? $level . ' Level' : 'N/A');
    }

    private function normalizeLevel(?string $level): string
    {
        return self::LEVEL_MAP[$level] ?? '100';
    }

    private function normalizeSemester(?string $semester): string
    {
        return (stripos((string) $semester, 'Second') !== false) ? 'Second' : 'First';
    }

    /**
     * Student profile page.
     */
    public function profileView(Request $request)
    {
        $user = Auth::user();

        $selectedLevel = $request->input('level', $user->level ?: '100');
        $selectedSemester = $request->input('semester', $user->semester ?: 'First');

        $configLevelKey = $this->normalizeLevel($selectedLevel);
        $semesterKey = $this->normalizeSemester($selectedSemester);

        $student = (object) [
            'name' => $user->name,
            'email' => $user->email,
            'matric_number' => $user->matric_number ?? '',
            'department' => $user->department ?? '',
            'phone_number' => $user->phone_number ?? '',
            'level' => $selectedLevel,
            'semester' => $selectedSemester,
            'level_label' => $this->levelLabel($selectedLevel),
        ];

        $curriculum = config('curriculum.levels', []);
        $levelData = $curriculum[$configLevelKey] ?? [];
        $curriculumCourses = $levelData['semesters'][$semesterKey] ?? [];

        foreach ($curriculumCourses as $courseData) {
            $course = Course::where('course_code', $courseData['code'])
                ->where('level', $configLevelKey)
                ->where('semester', $semesterKey)
                ->first() ?? new Course();

            $course->course_code = $courseData['code'];
            $course->level = $configLevelKey;
            $course->semester = $semesterKey;
            $course->course_title = $courseData['title'];
            $course->department = 'Computer Science';
            $course->units = $courseData['units'] ?? 3;
            $course->save();
        }

        $courseCodes = collect($curriculumCourses)->pluck('code')->values()->all();

        $availableCourses = Course::query()
            ->where('level', $configLevelKey)
            ->where('semester', $semesterKey)
            ->whereIn('course_code', $courseCodes)
            ->orderBy('course_code')
            ->get();

        $enrolledCourseIds = $user->courses()->pluck('courses.id')->all();

        $recentLogins = LoginActivity::where('user_id', $user->id)
            ->latest('logged_in_at')
            ->take(5)
            ->get();

        return view('student.profile', [
            'user' => $user,
            'student' => $student,
            'levelOptions' => $this->levelOptions(),
            'selectedLevel' => $selectedLevel,
            'selectedSemester' => $selectedSemester,
            'availableCourses' => $availableCourses,
            'enrolledCourseIds' => $enrolledCourseIds,
            'recentLogins' => $recentLogins,
        ]);
    }

    /**
     * Terminate or log out a specific login activity session.
     */
    public function logoutSession($id)
    {
        $user = Auth::user();
        $login = LoginActivity::where('id', $id)->where('user_id', $user->id)->first();

        if ($login) {
            $login->delete();
            return response()->json(['success' => true, 'message' => 'Session terminated successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Session not found.'], 404);
    }

    /**
     * Student dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $courses = $user->courses()->orderBy('course_code')->get();
        $courseCodes = $courses->pluck('course_code');

        $activeSession = AttendanceSession::where('is_active', true)
            ->whereIn('course_code', $courseCodes)
            ->latest()
            ->first();

        $hasCheckedInActive = false;
        if ($activeSession) {
            $hasCheckedInActive = Attendance::where('attendance_session_id', $activeSession->id)
                ->where('user_id', $user->id)
                ->exists();
        }

        $attendanceCount = Attendance::where('user_id', $user->id)->count();

        $recentAttendances = Attendance::with('session')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $timetableCount = Timetable::whereIn('course_code', $courseCodes)->count();

        $attendedByCourse = Attendance::with('session')
            ->where('user_id', $user->id)
            ->get()
            ->groupBy(fn ($attendance) => $attendance->session->course_code ?? 'unknown')
            ->map->count();

        $totalSessionsByCourse = AttendanceSession::whereIn('course_code', $courseCodes)
            ->get()
            ->groupBy('course_code')
            ->map->count();

        $courseAttendanceStats = $courses->map(function ($course) use ($attendedByCourse, $totalSessionsByCourse) {
            $attended = $attendedByCourse->get($course->course_code, 0);
            $total = $totalSessionsByCourse->get($course->course_code, 0);

            return (object) [
                'course_code' => $course->course_code,
                'course_title' => $course->course_title,
                'attended' => $attended,
                'total' => $total,
            ];
        });

        return view('student_dashboard', compact(
            'courses',
            'activeSession',
            'hasCheckedInActive',
            'attendanceCount',
            'recentAttendances',
            'timetableCount',
            'courseAttendanceStats'
        ));
    }

    /**
     * Camera / QR scanner.
     */
    public function cameraScan()
    {
        return view('student.camera_scan');
    }

    /**
     * Student timetable.
     */
    public function timetableView(Request $request)
    {
        $user = Auth::user();
        $curriculum = config('curriculum.levels', []);

        $selectedLevel = $user->level ?: '100';
        $selectedSemester = $user->semester ?: 'First';

        $configLevelKey = $this->normalizeLevel($selectedLevel);
        $semesterKey = $this->normalizeSemester($selectedSemester);

        $selectedLevelData = $curriculum[$configLevelKey] ?? [];
        $semesters = $selectedLevelData['semesters'] ?? [];
        $semesterCourses = $semesters[$semesterKey] ?? [];

        $levelCourses = collect($semesterCourses);
        $levelCourseCodes = $levelCourses->pluck('code')->all();

        $enrolledCourseCodes = $user->courses()->pluck('course_code')->all();

        $timetables = Timetable::whereIn('course_code', $levelCourseCodes)
            ->get()
            ->keyBy('course_code');

        return view('student.timetable', [
            'selectedLevelLabel' => $this->levelLabel($configLevelKey),
            'selectedSemester' => $semesterKey,
            'levelCourses' => $levelCourses,
            'courseCodes' => $enrolledCourseCodes,
            'timetables' => $timetables,
        ]);
    }

    /**
     * Generate course registration form.
     */
    public function courseForm(Request $request)
    {
        $user = Auth::user();
        $selectedSemester = $user->semester ? $user->semester . ' Semester' : 'First Semester';
        $enrolledCourses = $user->courses()->orderBy('course_code')->get();

        return view('student.course-form', [
            'user' => $user,
            'enrolledCourses' => $enrolledCourses,
            'selectedSemester' => $selectedSemester,
            'levelLabel' => $this->levelLabel($user->level),
        ]);
    }

    /**
     * Update student profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'matric_number' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'department' => ['nullable', 'string', 'max:255'],
            'level' => ['nullable', 'in:100,200,300,400,ND1,ND2,HND1,HND2'],
            'semester' => ['nullable', 'string'],
            'courses' => ['nullable', 'array'],
            'courses.*' => ['integer', 'exists:courses,id'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'current_password' => ['required', 'current_password'],
        ]);

        $user->update([
            'name' => $data['name'],
            'matric_number' => $data['matric_number'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
            'department' => $data['department'] ?? null,
            'level' => $data['level'] ?? null,
            'semester' => $data['semester'] ?? 'First',
        ]);

        if ($request->hasFile('photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->update(['profile_photo_path' => $path]);
        }

        $user->courses()->sync($data['courses'] ?? []);

        return redirect()
            ->route('student.profile')
            ->with('success', 'Profile updated successfully!');
    }
}