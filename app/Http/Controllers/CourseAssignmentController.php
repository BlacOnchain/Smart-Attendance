<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseAssignmentController extends Controller
{
    // Restricts this one utility page to specific accounts — not a new
    // role or permission system, just an allowlist check.
    private const ADMIN_EMAILS = [
        'lecturer@smartattendance.test', // TODO: replace with your real admin email(s)
    ];

    private function ensureAdmin(): void
    {
        if (!in_array(auth()->user()->email, self::ADMIN_EMAILS, true)) {
            abort(403, 'Not authorized to manage course assignments.');
        }
    }

    public function index()
    {
        $this->ensureAdmin();

        $courses = Course::with('lecturer')->orderBy('level')->orderBy('semester')->orderBy('course_code')->get();
        $lecturers = User::where('role', 'lecturer')->orderBy('name')->get();

        return view('admin.course-assignments', compact('courses', 'lecturers'));
    }

    public function update(Request $request, Course $course)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'lecturer_id' => ['nullable', 'exists:users,id'],
        ]);

        $course->update(['lecturer_id' => $data['lecturer_id'] ?? null]);

        return back()->with('success', "Updated {$course->course_code}.");
    }
}