<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'firstName' => 'required|max:30',
            'lastName' => 'required|max:30',
            'email' => 'bail|required|email|unique:users|max:30',
            'password' => 'bail|required|min:6',
            'role' => 'required',
        ]);

        $password = bcrypt($request->password);
        User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => $password,
            'role' => $request->role
        ]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'bail|required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            return response()->json([
                'msg' => 'You are logged in',
                'user' => $user,
                'third' => "Hello"
            ]);
        } else {
            return response()->json([
                'msg' => 'Unknown user'
            ], 401);
        }
    }

    public function getStudents()
    {
        return User::where('role', 'Student')->get();
    }

    public function getProfessors()
    {
        return User::where('role', 'Professor')->get();
    }


    public function getUserQuizzes(Request $request)
    {
        return Quiz::whereHas('users', function ($query) use ($request) {
            $query->where('user_id', $request->id);
        })
            ->get();
    }

    public function getUserCourses(Request $request)
    {
        return Course::whereHas('course_users', function ($query) use ($request) {
            $query->where('user_id', $request->id);
        })->with('lessons')->get();
    }

    public function countUserCourses(Request $request)
    {
        return Course::whereHas('course_users', function ($query) use ($request) {
            $query->where('user_id', $request->id);
        })->count();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function saveUserResults(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        if ($request->total >= $request->passing) {
            $res = "pass";
        } else $res = "fail";

        $user->user_quizzes()->attach($request->quiz_id, ['total_points' => $request->total, 'result' => $res]);

        return $user;
    }

    public function getUserResults(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        // return $user;

        return $user->whereHas('user_quizzes', function ($query) use ($request) {
            $query->where('quiz_id',  $request->quiz_id);
        })->with('user_quizzes')->get();
    }

    public function checkUserCourseQuiz(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        return $user->whereHas('user_quizzes', function ($query) use ($request) {
            $query->where('course_id',  $request->course_id);
        })->exists();
    }

    public function getUserCourseQuiz(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        return $user->whereHas('user_quizzes', function ($query) use ($request) {
            $query->where('course_id',  $request->course_id);
        })->with('user_quizzes')->first();
    }

    public function enrollInCourse(Request $request)
    {
        $course = Course::where('id', $request->course_id)->first();
        $user = User::where('id', $request->user_id)->first();

        $user->user_courses()->attach($course->id);
    }

    public function getUser(Request $request)
    {
        return User::where('id', $request->id)->first();
    }
}
