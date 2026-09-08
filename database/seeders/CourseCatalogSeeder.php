<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseCatalogSeeder extends Seeder
{
    /**
     * Push every course from config/curriculum.php into the `courses` table,
     * for every level and both semesters — not just the ones a student has
     * happened to visit.
     *
     * Mirrors the exact upsert logic already used in
     * StudentController::profileView(), so a course created here looks
     * identical to one lazily created by a student visiting their profile.
     */
    public function run(): void
    {
        $curriculum = config('curriculum.levels', []);

        if (empty($curriculum)) {
            $this->command->warn('config/curriculum.php returned no levels — nothing to seed. Check the config file exists and is cached correctly (php artisan config:clear).');
            return;
        }

        $created = 0;
        $updated = 0;

        foreach ($curriculum as $level => $levelData) {
            $semesters = $levelData['semesters'] ?? [];

            foreach ($semesters as $semester => $courses) {
                foreach ($courses as $courseData) {
                    $course = Course::where('course_code', $courseData['code'])
                        ->where('level', $level)
                        ->where('semester', $semester)
                        ->first();

                    $isNew = ! $course;
                    $course = $course ?? new Course();

                    $course->course_code = $courseData['code'];
                    $course->level = $level;
                    $course->semester = $semester;
                    $course->course_title = $courseData['title'];
                    $course->department = 'Computer Science';
                    $course->units = $courseData['units'] ?? 3;
                    $course->save();

                    $isNew ? $created++ : $updated++;
                }
            }
        }

        $this->command->info("Course catalog seeded: {$created} created, {$updated} already existed and were refreshed.");
    }
}