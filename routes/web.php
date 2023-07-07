<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\OptionController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);


Route::get('/get-students', [UserController::class, 'getStudents']);
Route::get('/get-user/{id}', [UserController::class, 'getUser']);
Route::get('/get-professors', [UserController::class, 'getProfessors']);
Route::post('/save-results', [UserController::class, 'saveUserResults']);
Route::get('/get-user-results/{user_id}/{quiz_id}', [UserController::class, 'getUserResults']);
Route::get('/check-user-course-quiz/{user_id}/{course_id}', [UserController::class, 'checkUserCourseQuiz']);
Route::get('/get-user-course-quiz/{user_id}/{course_id}', [UserController::class, 'getUserCourseQuiz']);

Route::post('course/upload', [CourseController::class, 'upload']);
Route::post('course/save-course', [CourseController::class, 'saveCourse']);
Route::get('course/get-courses', [CourseController::class, 'getCourses']);
Route::get('/get-professor-courses/{id}', [CourseController::class, 'getProfessorCourses']);
Route::get('/get-user-courses-for-subject/{id}/{subject}', [CourseController::class, 'getUserCoursesForSubject']);
Route::get('/get-professor-courses-for-subject/{id}/{subject}', [CourseController::class, 'getProfessorCoursesForSubject']);
Route::get('/get-courses-for-subject/{subject}', [CourseController::class, 'getCoursesForSubject']);

Route::get('course/get-courses-lessons', [CourseController::class, 'getCoursesLessons']);
Route::get('/get-course/{id}', [CourseController::class, 'getCourse']);
Route::post('/edit-course', [CourseController::class, 'editCourse']);
Route::post('edit-course/upload', [CourseController::class, 'upload']);
Route::post('{slug}/course/add-lesson', [CourseController::class, 'addLesson']);

Route::post('/enroll-user', [UserController::class, 'enrollInCourse']);
Route::get('/get-user-courses/{id}', [UserController::class, 'getUserCourses']);
Route::get('/count-user-courses/{id}', [UserController::class, 'countUserCourses']);
Route::get('/get-course-users/{id}', [CourseController::class, 'getCourseUsers']);
Route::get('/get-course-with-lessons/{id}', [CourseController::class, 'getCourseWithLessons']);
Route::post('/edit-course', [CourseController::class, 'editCourse']);
Route::post('/edit-course/upload', [CourseController::class, 'upload']);

Route::post('lesson/uploadPdf', [LessonController::class, 'uploadPdf']);
Route::post('/edit-lesson/uploadPdf', [LessonController::class, 'uploadPdf']);
Route::post('lesson/save-lesson', [LessonController::class, 'saveLesson']);
Route::post('lesson/save-lesson-for-course', [LessonController::class, 'saveLessonForCourse']);
Route::get('lesson/get-lessons', [LessonController::class, 'getLessons']);
Route::get('lesson/get-lessons-for-course/{title}', [LessonController::class, 'getLessonsForSubject']);
Route::get('get-lesson/{id}', [LessonController::class, 'getLesson']);
Route::get('/get-lessons-for-course/{id}', [LessonController::class, 'getLessonsForCourse']);
Route::post('/edit-lesson', [LessonController::class, 'editLesson']);


Route::get('/get-subjects', [SubjectController::class, 'getSubjects']);


Route::post('quiz/save-quiz', [QuizController::class, 'saveQuiz']);
Route::get('quiz/get-quizzes', [QuizController::class, 'getQuizzes']);
Route::get('quiz/get-last-quiz', [QuizController::class, 'getLastQuiz']);
Route::get('quiz/get-quizzes-for-course/{id}', [QuizController::class, 'getQuizzesForCourse']);
Route::get('get-quiz/{id}', [QuizController::class, 'getQuiz']);
Route::get('/get-course-quiz/{id}', [QuizController::class, 'getCourseQuiz']);
Route::get('/check-course-quiz/{id}', [QuizController::class, 'checkCourseQuiz']);

Route::post('question/save-question', [QuestionController::class, 'saveQuestion']);
Route::post('question/save-multiple-questions', [QuestionController::class, 'saveMultipleQuestions']);
Route::get('question/get-questions', [QuestionController::class, 'getQuestions']);
Route::get('get-question/{id}', [QuestionController::class, 'getQuestion']);
Route::get('/get-quiz-questions/{id}', [QuestionController::class, 'getQuizQuestions']);


Route::post('option/save-option', [OptionController::class, 'saveOption']);
Route::get('option/get-options', [OptionController::class, 'getOptions']);
Route::get('get-option/{id}', [OptionController::class, 'getOption']);
Route::get('/get-question-options/{id}', [OptionController::class, 'getQuestionOptions']);

Route::get('my-quizzes/{id}', [UserController::class, 'getUserQuizzes']);

// Route::any('{slug}', function () {
//     return view('welcome');
// });
