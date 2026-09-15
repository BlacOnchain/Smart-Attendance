<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::hasColumn('users', 'phone_number')) {
                    $table->string('phone_number')->nullable();
                }
                if (!Schema::hasColumn('users', 'role')) {
                    $table->string('role')->default('student');
                }
                if (!Schema::hasColumn('users', 'is_hod')) {
                    $table->boolean('is_hod')->default(false);
                }
                if (!Schema::hasColumn('users', 'semester')) {
                    $table->string('semester')->nullable();
                }
                if (!Schema::hasColumn('users', 'profile_photo_path')) {
                    $table->string('profile_photo_path')->nullable();
                }
                if (!Schema::hasColumn('users', 'otp_code')) {
                    $table->string('otp_code')->nullable();
                }
                if (!Schema::hasColumn('users', 'otp_expires_at')) {
                    $table->timestamp('otp_expires_at')->nullable();
                }
            });

            if (Schema::hasColumn('users', 'first_name') && Schema::hasColumn('users', 'last_name')) {
                DB::table('users')->whereNull('name')->orWhere('name', '')->get()->each(function ($user) {
                    DB::table('users')->where('id', $user->id)->update([
                        'name' => trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')),
                    ]);
                });
            }

            if (Schema::hasColumn('users', 'phone')) {
                DB::table('users')->whereNull('phone_number')->update([
                    'phone_number' => DB::raw('phone'),
                ]);
            }
        }

        if (Schema::hasTable('courses')) {
            Schema::table('courses', function (Blueprint $table) {
                if (!Schema::hasColumn('courses', 'semester')) {
                    $table->string('semester')->nullable();
                }
                if (!Schema::hasColumn('courses', 'units')) {
                    $table->unsignedTinyInteger('units')->default(3);
                }
                if (!Schema::hasColumn('courses', 'lecturer_id')) {
                    $table->foreignId('lecturer_id')->nullable()->constrained('users')->nullOnDelete();
                }
            });
        }

        if (Schema::hasTable('attendance_sessions')) {
            Schema::table('attendance_sessions', function (Blueprint $table) {
                if (!Schema::hasColumn('attendance_sessions', 'token_generated_at')) {
                    $table->timestamp('token_generated_at')->nullable();
                }
                if (!Schema::hasColumn('attendance_sessions', 'lecturer_id')) {
                    $table->foreignId('lecturer_id')->nullable()->constrained('users')->nullOnDelete();
                }
            });
        }

        if (Schema::hasTable('login_activities')) {
            Schema::table('login_activities', function (Blueprint $table) {
                if (!Schema::hasColumn('login_activities', 'location')) {
                    $table->string('location')->nullable();
                }
                if (!Schema::hasColumn('login_activities', 'session_id')) {
                    $table->string('session_id')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        // This migration only fills schema gaps across existing installs.
        // Older columns are intentionally preserved so rollback cannot remove user data.
    }
};
