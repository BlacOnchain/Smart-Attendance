<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSession extends Model
{
    use HasFactory;

    protected $fillable = ['course_code', 'session_token', 'is_active', 'lecturer_id', 'token_generated_at'];

    // Without this cast, token_generated_at comes back as a plain string,
    // and isTokenExpired()'s ->diffInSeconds(now()) call in
    // AttendanceController would throw a fatal error the first time a
    // session actually had a value in that column.
    protected $casts = [
        'token_generated_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'attendance_session_id');
    }

    // Needed by lecturer.blade.php ($session->lecturer->name, HOD view).
    // Without this, ->lecturer always resolves to null and every session
    // silently shows "Unknown" instead of the lecturer who started it.
    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }
}