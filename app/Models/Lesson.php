<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subject',
        'description',
        'pdf',
        'user_id',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_lesson', 'lesson_id', 'course_id');
    }
}
