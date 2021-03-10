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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $category_id = $request->has('category_id') ? $request->get('category_id') : '';
        $query = Course::with(['quiz.questions' => function($query){
            $query->where('questions.status', '1')->orderBy('place', 'asc');
        }, 'modules'])->where('status', '1');

        if(!empty($category_id)){
          $query = $query->where('category_id', $category_id);
        }

        $courses = $query->get();

        $user->load('course_attempts');
        
        return view('frontend.home', compact('courses', 'user'));
    }

    public function getCourse(Request $request)
    {
        $module_id = $request->module_id;
        /*$query = Module::where('course_id', $request->course_id)->where('status', '1')->where('place', '>', $module->place)->orderBy('place', 'asc')->get();*/
        $course = Course::with(['modules' => function($query){
            $query->where('status', '1')->orderBy('place', 'asc');
        }])->find($request->course_id);

        $module = Module::find($module_id);

        $locale = config('app.locale');
        $title = config('app.locale').'_title';
        $videoname = config('app.locale').'_video_file_name';
        $videourl = config('app.locale').'_video_url';
        $slideurl = config('app.locale').'_slide_url';
        $videocontenttype = config('app.locale').'_video_content_type';
        $videohtml = config('app.locale').'_video_html';
        $videolink = config('app.locale').'_video_link';

        if($course->modules()->exists() && $course->modules()->count() > 1) {
          $modules = '';
          foreach($course->modules as $cmodule){
          $modules .= '<div class="d-flex vrow" data-course="'.$course->id.'" data-value="'.$cmodule->id.'">
              <div class="vthumb"><img src="images/video-thumb.jpg" alt=""></div>
              <div class="vcon">
                <h5>'.$cmodule->$title.'</h5>
                <p>3:50</p>
              </div>
              <div class="vbtn d-flex align-items-center justify-content-center">
                
                <button class="playbtn ml-2" type="button" >
                  <img src="">
                </button>
              </div>
            </div>';
          }
        }

        echo  $modules;

        //return $courses ;
         
    }

}
