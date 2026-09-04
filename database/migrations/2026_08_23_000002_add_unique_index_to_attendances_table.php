<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Safety net: if any duplicate (session, user) rows already
        // exist from before this fix, keep only the earliest scan per
        // pair so the unique index below can actually be created.
        $duplicates = DB::table('attendances')
            ->select('attendance_session_id', 'user_id', DB::raw('MIN(id) as keep_id'))
            ->groupBy('attendance_session_id', 'user_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $dup) {
            DB::table('attendances')
                ->where('attendance_session_id', $dup->attendance_session_id)
                ->where('user_id', $dup->user_id)
                ->where('id', '!=', $dup->keep_id)
                ->delete();
        }

        Schema::table('attendances', function (Blueprint $table) {
            // The application already checks "already checked in" before
            // inserting, but that check-then-insert has a race window
            // under concurrent requests. This index is the hard backstop:
            // the database itself will refuse a second row for the same
            // student in the same session, no matter how the request
            // arrived.
            $table->unique(['attendance_session_id', 'user_id'], 'attendance_session_user_unique');
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropUnique('attendance_session_user_unique');
        });
    }
};
