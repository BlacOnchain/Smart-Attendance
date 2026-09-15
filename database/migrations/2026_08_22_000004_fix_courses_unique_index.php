<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
