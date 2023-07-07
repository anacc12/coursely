<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    // public function addLesson(Request $request, Course $course)
    // {
    //     $course->lessons()->attach($request->lessons);
    // }

    public function getCoursesLessons()
    {
        return Course::with('lessons')->get();
    }

    public function getCourseUsers(Request $request)
    {
        return User::whereHas('user_courses', function ($query) use ($request) {
            $query->where('course_id', $request->id);
        })->get();
    }

    public function getCourseWithLessons(Request $request)
    {
        return Course::where('id', $request->id)->with('lessons')->get();
    }


    public function getCourses()
    {
        return Course::all();
    }


    public function getProfessorCourses(Request $request)
    {
        return Course::where('professor_id', $request->id)->with('lessons')->get();
    }

    public function getCourse(Request $request)
    {
        return Course::where('id', $request->id)->first();
    }

    public function getUserCoursesForSubject(Request $request)
    {
        $user_courses = Course::whereHas('course_users', function ($query) use ($request) {
            $query->where('user_id', $request->id);
        })->with('lessons')->where('subject', $request->subject)->get();

        return $user_courses;
    }

    public function getProfessorCoursesForSubject(Request $request)
    {
        return Course::where([
            ['professor_id', $request->id],
            ['subject', $request->subject]
        ])->with('lessons')->get();
    }

    public function getCoursesForSubject(Request $request)
    {
        return Course::where('subject', $request->subject)->with('lessons')->get();
    }

    public function editCourse(Request $request)
    {
        $this->validate($request, [
            'title' => 'bail|required|string|max:50',
            'numOfPeople' => 'nullable|numeric',
            'totalTime' => 'nullable|numeric',
            'description' => 'required',
            'subject' => 'required',
            'image' => 'nullable',
            'professor_id' => 'nullable',
            'difficulty' => 'required'
        ]);

        $course = Course::where('id', $request->id)->first();

        if (count($request->lessons) > 1) {
            $course->lessons()->sync($request->lesson_ids);
        }

        $course->update([
            'title' => $request->title,
            'numOfPeople' => $request->numOfPeople,
            'totalTime' => $request->totalTime,
            'description' => $request->description,
            'subject' => $request->subject,
            'image' => $request->image,
            'professor_id' => $request->professor_id,
            'difficulty' => $request->difficulty
        ]);

        return $course;
    }

    public function saveCourse(Request $request)
    {

        $this->validate($request, [
            'title' => 'bail|required|string|max:50',
            'numOfPeople' => 'nullable|numeric',
            'totalTime' => 'nullable|numeric',
            'description' => 'required',
            'image' => 'nullable',
            'user_id' => 'required',
            'professor_id' => 'required',
            'difficulty' => 'required',
            'subject' => 'required'
        ]);

        $course = Course::create([
            'title' => $request->title,
            'numOfPeople' => $request->numOfPeople,
            'totalTime' => $request->totalTime,
            'description' => $request->description,
            'image' => $request->image,
            'user_id' => $request->user_id,
            'professor_id' => $request->professor_id,
            'difficulty' => $request->difficulty,
            'subject' => $request->subject
        ]);


        for ($i = 0; $i < count($request->lessons); $i++) {
            $course->lessons()->attach($request->lessons[$i]);
        }

        return $course;
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,png,jpg'
        ]);

        $imageName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $imageName);
        return $imageName;
    }
}
