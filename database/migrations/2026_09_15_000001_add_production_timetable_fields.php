<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('timetables')) {
            return;
        }

        Schema::table('timetables', function (Blueprint $table) {
            if (! Schema::hasColumn('timetables', 'level')) {
                $table->string('level')->nullable()->index();
            }
            if (! Schema::hasColumn('timetables', 'semester')) {
                $table->string('semester')->nullable()->index();
            }
            if (! Schema::hasColumn('timetables', 'academic_session')) {
                $table->string('academic_session')->nullable()->index();
            }
            if (! Schema::hasColumn('timetables', 'venue')) {
                $table->string('venue')->nullable();
            }
            if (! Schema::hasColumn('timetables', 'lecturer_id')) {
                $table->foreignId('lecturer_id')->nullable()->constrained('users')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('timetables')) {
            return;
        }

        Schema::table('timetables', function (Blueprint $table) {
            if (Schema::hasColumn('timetables', 'lecturer_id')) {
                $table->dropConstrainedForeignId('lecturer_id');
            }
            foreach (['level', 'semester', 'academic_session', 'venue'] as $column) {
                if (Schema::hasColumn('timetables', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
