<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuiz extends Model
{
    use HasFactory;

    public function userQuizPoints()
    {
        return $this->belongsTo(Quiz::class, 'total_points');
    }

    public function userQuizResult()
    {
        return $this->belongsTo(Quiz::class, 'result');
    }
}
