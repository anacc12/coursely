<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'course_id',
        'passing_points'
    ];

    public function quiz_users()
    {
        return $this->belongsToMany(User::class, 'user_quiz')->withPivot('total_points', 'result');
    }
}
