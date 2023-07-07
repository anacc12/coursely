<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'numOfPeople',
        'totalTime',
        'description',
        'image',
        'user_id',
        'professor_id',
        'subject',
        'difficulty'
    ];

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'course_lesson');
    }

    public function course_users()
    {
        return $this->belongsToMany(User::class, 'user_course',  'course_id', 'user_id');
    }
}
