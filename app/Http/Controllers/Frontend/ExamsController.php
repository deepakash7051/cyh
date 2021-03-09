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

        $course = Course::with(['quiz.questions' => function($query){
            $query->where('questions.status', '1')->orderBy('place', 'asc');
        }])->whereHas('quiz', function($query){
            $query->where('status', '1');
        })->find($id);

        return view('frontend.exams.index', compact('course'));

    }
}
