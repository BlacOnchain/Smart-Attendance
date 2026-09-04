<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('login_activities', function (Blueprint $table) {
            if (!Schema::hasColumn('login_activities', 'session_id')) {
                $table->string('session_id')->nullable()->after('user_agent');
            }
        });
    }

    public function down(): void
    {
        Schema::table('login_activities', function (Blueprint $table) {
            $table->dropColumn('session_id');
        });
    }
};
