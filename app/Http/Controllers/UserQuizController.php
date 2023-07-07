<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Quiz;

class UserQuizController extends Controller
{
    public function getUserQuizzes(Request $request)
    {
        return Quiz::where('quiz_id', $request->id)->get();
    }
}
