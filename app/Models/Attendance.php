<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['attendance_session_id', 'user_id', 'scanned_at'];

    // Cast scanned_at as a datetime object so ->format() works perfectly
    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    // Relationship to get the student's profile info
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function session()
    {
        return $this->belongsTo(AttendanceSession::class, 'attendance_session_id');
    }
}
