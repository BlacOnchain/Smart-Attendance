<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

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
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : null;
    }
}