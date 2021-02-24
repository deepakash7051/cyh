<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\Quiz;

class ExamsController extends Controller
{
    public function index(Request $request, $id)
    {

    	$course = Course::with(['quizzes' => function($query){
    		$query->where('status', '1')->orderBy('place', 'asc');
    	}])->find($id);

    	$quiz_id = $request->has('quiz_id') ? $request->get('quiz_id') : $course->quizzes()->first()->id;

    	$quiz = Quiz::with(['questions' => function($query){
    		$query->where('status', '1')->orderBy('place', 'asc');
    	}])->find($quiz_id);

        return view('frontend.exam', compact('course', 'quiz'));
    }
}
