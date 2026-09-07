<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseAssignmentController extends Controller
{
    // Previously this checked a hardcoded ADMIN_EMAILS array with a
    // "TODO: replace with your real admin email(s)" comment. That's the
    // kind of thing that gets forgotten in production and either locks
    // everyone out or, worse, leaves a test email with real access.
    //
    // The User model already has an `is_hod` flag used elsewhere for the
    // HOD view — course assignment is squarely an HOD responsibility, so
    // we use that instead of maintaining a second, parallel permission
    // list that can drift out of sync.
    private function ensureAdmin(): void
    {
        if (!auth()->check() || !auth()->user()->is_hod) {
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