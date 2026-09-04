<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseAssignmentController;
use App\Http\Controllers\StudentController;
use App\Models\LoginActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/lecturer/login', function () {
    return view('auth.lecturer-login');
})->name('lecturer.login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();
        $ip = $request->ip();

        $isNewIp = !LoginActivity::where('user_id', $user->id)
            ->where('ip_address', $ip)
            ->exists();

        LoginActivity::create([
            'user_id' => $user->id,
            'ip_address' => $ip,
            'user_agent' => $request->userAgent(),
            'logged_in_at' => now(),
        ]);

        $target = $user && $user->role === 'lecturer'
            ? route('lecturer.dashboard')
            : route('student.dashboard');

        return redirect()->intended($target);
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
})->name('login.submit');

Route::post('/lecturer/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();

        if ($user && $user->role === 'lecturer') {
            $ip = $request->ip();

            $isNewIp = !LoginActivity::where('user_id', $user->id)
                ->where('ip_address', $ip)
                ->exists();

            LoginActivity::create([
                'user_id' => $user->id,
                'ip_address' => $ip,
                'user_agent' => $request->userAgent(),
                'logged_in_at' => now(),
            ]);

            return redirect()->intended(route('lecturer.dashboard'));
        }

        Auth::logout();

        return back()->withErrors([
            'email' => 'This account is not a lecturer account.',
        ])->onlyInput('email');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
})->name('lecturer.login.submit');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// --- OTP Forgot Password Routes ---
Route::post('/password/otp/send', [AuthController::class, 'sendOtpCode'])->name('password.otp.send');
Route::post('/password/otp/verify', [AuthController::class, 'verifyOtpCode'])->name('password.otp.verify');
Route::post('/password/otp/reset', [AuthController::class, 'resetPasswordWithOtp'])->name('password.otp.reset');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:lecturer'])->group(function () {
    Route::get('/lecturer/dashboard', [AttendanceController::class, 'lecturerDashboard'])->name('lecturer.dashboard');
    Route::get('/lecturer/students', [AttendanceController::class, 'studentsView'])->name('lecturer.students');
    Route::get('/lecturer/courses', [AttendanceController::class, 'coursesView'])->name('lecturer.courses');
    Route::post('/lecturer/session/start', [AttendanceController::class, 'startSession'])->name('lecturer.session.start');
    Route::post('/lecturer/session/{id}/rotate', [AttendanceController::class, 'rotateToken'])->name('lecturer.session.rotate');
    Route::post('/lecturer/session/{id}/close', [AttendanceController::class, 'closeSession'])->name('lecturer.session.close');
    Route::post('/lecturer/course/{id}/claim', [AttendanceController::class, 'claimCourse'])->name('lecturer.course.claim');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/course-assignments', [CourseAssignmentController::class, 'index'])->name('admin.course-assignments');
    Route::post('/admin/course-assignments/{course}', [CourseAssignmentController::class, 'update'])->name('admin.course-assignments.update');
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/student/profile', [StudentController::class, 'profileView'])->name('student.profile');
    Route::post('/student/profile/update', [StudentController::class, 'updateProfile'])->name('student.profile.update');
    
    // Session termination route
    Route::post('/student/profile/logout-session/{id}', [StudentController::class, 'logoutSession'])->name('student.profile.logout-session');

    // Official Course Registration Form Slip Route
    Route::get('/student/course-form', [StudentController::class, 'courseForm'])->name('student.course-form');

    Route::get('/student/timetable', [StudentController::class, 'timetableView'])->name('student.timetable');
    Route::get('/student/camera', [StudentController::class, 'cameraScan'])->name('student.camera');
    Route::get('/student/scan/{token}', [AttendanceController::class, 'showScanPage'])->name('student.scan');
    Route::post('/student/log/{token}', [AttendanceController::class, 'logAttendance'])->name('student.log');
});