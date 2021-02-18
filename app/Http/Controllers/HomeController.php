<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Libraries\OnewaySms;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $courses = Course::where('status', '1')->get();
        
        return view('home', compact('courses'));
    }

}
