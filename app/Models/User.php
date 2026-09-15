<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_hod',
        'matric_number',
        'phone_number',
        'department',
        'level',
        'semester',
        'profile_photo_path',
        'profile_photo_data',
        'profile_photo_mime',
        'otp_code',          // Added for password reset
        'otp_expires_at',    // Added for password reset
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_hod' => 'boolean',
        'otp_expires_at' => 'datetime',
    ];

    /**
     * Relationship: A user has many courses (student enrollments).
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user');
    }

    /**
     * Relationship: A user (lecturer) can have started many attendance sessions.
     */
    public function attendanceSessions()
    {
        return $this->hasMany(AttendanceSession::class, 'lecturer_id');
    }

    /**
     * Full URL to the profile photo, or null if none uploaded.
     */
    public function getProfilePhotoUrlAttribute(): ?string
    {
        if (! $this->profile_photo_path) {
            return null;
        }

        $version = $this->updated_at?->timestamp ?? time();

        return route('profile.photo', ['path' => $this->profile_photo_path]) . '?v=' . $version;
    }
}
