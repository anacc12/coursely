<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Subject;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function getLessons()
    {
        return Lesson::all();
    }

    public function getLesson(Request $request)
    {
        return Lesson::where('id', $request->id)->get();
    }

    public function getLessonsForSubject(String $string)
    {
        return Lesson::where('subject', $string)->get();
    }

    public function getLessonsForCourse(Request $request)
    {
        return Lesson::whereHas('courses', function ($query) use ($request) {
            $query->where('course_id', $request->id);
        })->get();
    }

    public function saveLesson(Request $request)
    {

        $this->validate($request, [
            'title' => 'bail|required|string|max:50',
            'subject' => 'required',
            'pdf' => 'nullable',
            'description' => 'required',
            'user_id' => 'required',
        ]);

        $Lesson = Lesson::create([
            'title' => $request->title,
            'subject' => $request->subject,
            'description' => $request->description,
            'pdf' => $request->pdf,
            'user_id' => $request->user_id,
        ]);

        return $Lesson;
    }


    public function saveLessonForCourse(Request $request)
    {

        $this->validate($request, [
            'title' => 'bail|required|string|max:50',
            'subject' => 'required',
            'pdf' => 'nullable',
            'description' => 'required',
            'user_id' => 'required',
        ]);

        $lesson = Lesson::create([
            'title' => $request->title,
            'subject' => $request->subject,
            'description' => $request->description,
            'pdf' => $request->pdf,
            'user_id' => $request->user_id,
        ]);

        $course = Course::where('id', $request->course_id)->first();

        $course->lessons()->attach($lesson->id);

        return $lesson;
    }

    public function uploadPdf(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:pdf'
        ]);

        $fileName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $fileName);
        return $fileName;
    }

    public function editLesson(Request $request)
    {
        $this->validate($request, [
            'title' => 'bail|required|string|max:50',
            'subject' => 'required',
            'pdf' => 'nullable',
            'description' => 'required',
        ]);

        return Lesson::where('id', $request->id)->update([
            'title' => $request->title,
            'subject' => $request->subject,
            'description' => $request->description,
            'pdf' => $request->pdf
        ]);
    }
}
