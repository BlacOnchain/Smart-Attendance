<?php

namespace Tests\Feature;

use App\Models\AttendanceSession;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationAndAttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_students_can_register_and_are_sent_to_their_profile(): void
    {
        $response = $this->post(route('register.submit'), [
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
            'email' => 'ada@example.com',
            'phone' => '08000000000',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('student.profile'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'ada@example.com',
            'name' => 'Ada Lovelace',
            'role' => 'student',
            'phone_number' => '08000000000',
        ]);
    }

    public function test_lecturer_login_page_rejects_student_accounts(): void
    {
        User::factory()->create([
            'email' => 'student@example.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);

        $response = $this->post(route('lecturer.login.submit'), [
            'email' => 'student@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_a_student_cannot_record_attendance_without_course_enrollment(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $lecturer = User::factory()->create(['role' => 'lecturer']);
        $course = Course::create([
            'course_code' => 'COM 999',
            'course_title' => 'Test Course',
            'level' => '100',
            'department' => 'Computer Science',
            'semester' => 'First',
            'units' => 3,
            'lecturer_id' => $lecturer->id,
        ]);
        $session = AttendanceSession::create([
            'course_code' => $course->course_code,
            'session_token' => 'test-token',
            'token_generated_at' => now(),
            'is_active' => true,
            'lecturer_id' => $lecturer->id,
        ]);

        $response = $this->actingAs($student)->post(route('student.log', $session->session_token));

        $response->assertForbidden();
        $this->assertDatabaseCount('attendances', 0);
    }
}
