<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    // $table removed — Laravel already infers 'courses' from the class
    // name, so the explicit override was dead weight.

    protected $fillable = [
        'course_code',
        'course_title',
        'level',
        'department',
        'semester',
        'units',
        'lecturer_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user');
    }

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }
}