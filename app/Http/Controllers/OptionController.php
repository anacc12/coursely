<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function getOptions()
    {
        return Option::all();
    }

    public function getOption(Request $request)
    {
        return Option::where('id', $request->id)->get();
    }

    public function getQuestionOptions(Request $request)
    {
        return Option::where('question_id', $request->id)->get();
    }

    public function saveOption(Request $request)
    {
        $Option = Option::create([
            'text' => $request->text,
            'points' => $request->points,
            'question_id' => $request->question_id,
        ]);

        return $Option;
    }
}
