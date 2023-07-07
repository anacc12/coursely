<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;

class QuizController extends Controller
{

    public function getQuizzes()
    {
        return Quiz::all();
    }

    public function getQuiz(Request $request)
    {
        return Quiz::where('id', $request->id)->get();
    }

    public function getCourseQuiz(Request $request)
    {
        return Quiz::where('course_id', $request->id)->get();
    }

    public function checkCourseQuiz(Request $request)
    {
        $quiz = Quiz::where('course_id', $request->id)->first();
        if ($quiz != '')
            return true;
        else return false;
    }

    public function saveQuiz(Request $request)
    {
        $quiz = Quiz::create([
            'title' => $request->title,
            'passing_points' => $request->passing_points,
            'course_id' => $request->course_id,
        ])->id;

        return $quiz;
    }

    public function getLastQuiz()
    {
        return $this->getValue();
    }
}
