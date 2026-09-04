<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendance_sessions', function (Blueprint $table) {
            // Timestamp of when the *current* session_token was issued.
            // Every scan is validated against how old this is — that's
            // what makes a screenshotted/forwarded QR code stop working
            // a few seconds after it's captured.
            $table->timestamp('token_generated_at')->nullable()->after('session_token');
        });

        // Backfill existing rows so nothing already-active gets treated
        // as "infinitely stale" the moment this migration runs.
        DB::table('attendance_sessions')
            ->whereNull('token_generated_at')
            ->update(['token_generated_at' => now()]);
    }

    public function down(): void
    {
        Schema::table('attendance_sessions', function (Blueprint $table) {
            $table->dropColumn('token_generated_at');
        });
    }
};
