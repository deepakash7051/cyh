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

    public function sendcode(Request $request){

        $code = rand(1000, 9999);
        $phone = $request->input('phone');
        $isd_code = $request->get('isd_code');
        $debug = false;
        $mobile = $isd_code.$phone;

        //$username = 'API8YR8ASWL8V';
        //$password = 'API8YR8ASWL8V8YR8A';

        $result = OnewaySms::send($mobile, $code, $debug);

        print_r($result);
    }
}
