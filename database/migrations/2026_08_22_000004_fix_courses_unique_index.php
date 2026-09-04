<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Rows in `courses` are fully regenerated from config/curriculum.php
        // every time profileView() runs, so it's safe to clear out whatever
        // is here now - including the stale rows (null/mismatched semester)
        // left behind by the earlier broken version of the code that are
        // causing the duplicate-entry error.
        // Uses delete() rather than truncate() because course_user has a
        // foreign key onto courses.id; delete() lets that cascade cleanly.
        DB::table('courses')->delete();

        Schema::table('courses', function (Blueprint $table) {
            // Drop the old single-column unique index (this is the default
            // name Laravel gave it: courses_course_code_unique).
            $table->dropUnique('courses_course_code_unique');

            // The app looks up/creates courses by this compound key, so the
            // database constraint needs to match it.
            $table->unique(['course_code', 'level', 'semester'], 'courses_code_level_semester_unique');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropUnique('courses_code_level_semester_unique');
            $table->unique('course_code');
        });
    }
};
