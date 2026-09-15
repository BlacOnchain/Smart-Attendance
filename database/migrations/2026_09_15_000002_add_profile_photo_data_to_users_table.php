<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'profile_photo_data')) {
                $table->mediumText('profile_photo_data')->nullable();
            }
            if (! Schema::hasColumn('users', 'profile_photo_mime')) {
                $table->string('profile_photo_mime', 100)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('users', 'profile_photo_data')) {
                $columns[] = 'profile_photo_data';
            }
            if (Schema::hasColumn('users', 'profile_photo_mime')) {
                $columns[] = 'profile_photo_mime';
            }
            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }
};
