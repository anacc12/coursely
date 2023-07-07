<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function getQuestions()
    {
        return Question::all();
    }

    public function getQuestion(Request $request)
    {
        return Question::where('id', $request->id)->get();
    }

    public function getQuizQuestions(Request $request)
    {
        return Question::where('quiz_id', $request->id)->get();
    }

    public function saveQuestion(Request $request)
    {
        return Question::create([
            'text' => $request->text,
            'quiz_id' => $request->quiz_id,
        ]);
    }

    public function saveMultipleQuestions(Request $request)
    {
        for ($i = 0; $i < count($request->questions); $i++) {
            $question = Question::insertGetId([
                'text' => $request->questions[$i]['text'],
                'quiz_id' => $request->quiz_id,
            ]);

            for ($j = 0; $j < count($request->options); $j++) {
                if ($request->options[$j]['quest_id'] == $i) {
                    Option::insert([
                        'text' => $request->options[$j]['text'],
                        'points' => $request->options[$j]['points'],
                        'question_id' => $question,
                    ]);
                }
            }
        }

        return $question;
    }
}
