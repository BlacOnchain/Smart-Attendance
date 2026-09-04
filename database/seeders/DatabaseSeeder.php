<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Add sample courses for your levels
        $courses = [
            // ND1 (Level 100) - First Semester
            ['course_code' => 'GNS 101', 'course_title' => 'Use of English I', 'department' => 'Computer Science', 'level' => '100', 'units' => 2],
            ['course_code' => 'COM 111', 'course_title' => 'Introduction to Computer Science', 'department' => 'Computer Science', 'level' => '100', 'units' => 3],
            ['course_code' => 'COM 112', 'course_title' => 'Computer Programming I', 'department' => 'Computer Science', 'level' => '100', 'units' => 3],
            ['course_code' => 'COM 113', 'course_title' => 'Digital Electronics', 'department' => 'Computer Science', 'level' => '100', 'units' => 2],
            ['course_code' => 'MTH 111', 'course_title' => 'Elementary Mathematics I', 'department' => 'Computer Science', 'level' => '100', 'units' => 3],
            ['course_code' => 'PHY 101', 'course_title' => 'General Physics I', 'department' => 'Computer Science', 'level' => '100', 'units' => 2],

            // ND2 (Level 200) - First Semester
            ['course_code' => 'COM 211', 'course_title' => 'Computer Programming II', 'department' => 'Computer Science', 'level' => '200', 'units' => 3],
            ['course_code' => 'COM 212', 'course_title' => 'Operating Systems', 'department' => 'Computer Science', 'level' => '200', 'units' => 3],
            ['course_code' => 'COM 213', 'course_title' => 'Database Management Systems', 'department' => 'Computer Science', 'level' => '200', 'units' => 3],

            // HND1 (Level 300) - First Semester
            ['course_code' => 'COM 311', 'course_title' => 'Advanced Database Systems', 'department' => 'Computer Science', 'level' => '300', 'units' => 3],
            ['course_code' => 'COM 312', 'course_title' => 'Software Engineering', 'department' => 'Computer Science', 'level' => '300', 'units' => 3],

            // HND2 (Level 400) - First Semester
            ['course_code' => 'COM 411', 'course_title' => 'Distributed Computing', 'department' => 'Computer Science', 'level' => '400', 'units' => 3],
            ['course_code' => 'COM 412', 'course_title' => 'Project Management', 'department' => 'Computer Science', 'level' => '400', 'units' => 3],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(
                ['course_code' => $course['course_code']],
                $course
            );
        }
    }
}