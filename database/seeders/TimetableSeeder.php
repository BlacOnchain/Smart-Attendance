<?php

namespace Database\Seeders;

use App\Models\Timetable;
use Illuminate\Database\Seeder;

class TimetableSeeder extends Seeder
{
    /**
     * Standard 7-slot weekly pattern used for every level/semester group.
     * 2 classes each on Mon/Tue, 1 each on Wed/Thu/Fri = 7 slots, no
     * overlaps within a day since times don't clash.
     */
    private const SLOT_PATTERN = [
        ['day' => 'Monday',    'start' => '08:00:00', 'end' => '10:00:00'],
        ['day' => 'Monday',    'start' => '10:15:00', 'end' => '12:15:00'],
        ['day' => 'Tuesday',   'start' => '08:00:00', 'end' => '10:00:00'],
        ['day' => 'Tuesday',   'start' => '10:15:00', 'end' => '12:15:00'],
        ['day' => 'Wednesday', 'start' => '08:00:00', 'end' => '10:00:00'],
        ['day' => 'Thursday',  'start' => '08:00:00', 'end' => '10:00:00'],
        ['day' => 'Friday',    'start' => '08:00:00', 'end' => '10:00:00'],
    ];

    /**
     * All 56 courses, grouped exactly as in the curriculum
     * (100-400 level, First/Second semester, 7 courses each).
     */
    private const SCHEDULE_GROUPS = [
        // 100 Level - First Semester
        ['GNS 101', 'COM 111', 'COM 112', 'COM 113', 'MTH 111', 'PHY 101', 'GNS 103'],
        // 100 Level - Second Semester
        ['GNS 102', 'COM 121', 'COM 122', 'COM 123', 'MTH 121', 'STA 121', 'GNS 104'],
        // 200 Level - First Semester
        ['COM 211', 'COM 212', 'COM 213', 'COM 214', 'COM 215', 'MTH 211', 'ENT 211'],
        // 200 Level - Second Semester
        ['COM 221', 'COM 222', 'COM 223', 'COM 224', 'COM 225', 'ENT 221', 'IT 200'],
        // 300 Level - First Semester
        ['COM 311', 'COM 312', 'COM 313', 'COM 314', 'COM 315', 'COM 316', 'GNS 311'],
        // 300 Level - Second Semester
        ['COM 321', 'COM 322', 'COM 323', 'COM 324', 'COM 325', 'COM 326', 'PRO 320'],
        // 400 Level - First Semester
        ['COM 411', 'COM 412', 'COM 413', 'COM 414', 'COM 415', 'COM 416', 'COM 417'],
        // 400 Level - Second Semester
        ['COM 421', 'COM 422', 'COM 423', 'COM 424', 'COM 425', 'COM 426', 'ENT 421'],
    ];

    public function run(): void
    {
        $created = 0;
        $skipped = 0;

        foreach (self::SCHEDULE_GROUPS as $courseCodes) {
            foreach ($courseCodes as $index => $code) {
                $slot = self::SLOT_PATTERN[$index];

                $timetable = Timetable::firstOrNew(['course_code' => $code]);

                if ($timetable->exists) {
                    $skipped++;
                    continue;
                }

                $timetable->course_code = $code;
                $timetable->day_of_week = $slot['day'];
                $timetable->start_time = $slot['start'];
                $timetable->end_time = $slot['end'];
                $timetable->save();

                $created++;
            }
        }

        $this->command->info("Timetable seeding complete: {$created} created, {$skipped} already existed.");
    }
}
