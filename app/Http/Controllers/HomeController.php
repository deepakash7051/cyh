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
    public function index()
    {
        $courses = Course::with(['course_videos' => function($query){
            $query->where('status', '1');
        }, 'course_slides' => function($query){
            $query->where('status', '1');
        }])->where('status', '1')->get();
        
        return view('frontend.home', compact('courses'));
    }

    public function getCourse(Request $request)
    {
        $video_id = $request->video_id;
        $course = Course::with(['course_videos' => function($query){
            $query->where('status', '1')->orderBy('place', 'asc');
        }, 'course_slides' => function($query){
            $query->where('status', '1')->orderBy('place', 'asc');
        }])->find($request->course_id);

        $locale = config('app.locale');
        $title = config('app.locale').'_title';
        $attachment_url = config('app.locale').'_attachment_url';
        $content_type = config('app.locale').'_attachment_content_type';

        if($course->course_videos()->exists()) {
            $videotitle = empty($video_id) ? $course->course_videos->first()->$title : $course->course_videos->find($video_id)->$title;
            $video_attachment_url = empty($video_id) ? $course->course_videos->first()->$attachment_url : $course->course_videos->find($video_id)->$attachment_url;
            $video_content_type = empty($video_id) ? $course->course_videos->first()->$content_type : $course->course_videos->find($video_id)->$content_type;
            $currentvideo = empty($video_id) ? $course->course_videos->first() : $course->course_videos->find($video_id);

    $html = '<div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">
            <span>'.trans('global.pages.frontend.home.course_preview').'</span> '.$videotitle.'</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="video-main">
        <video width="320" height="240" controls>
          <source src="'.$video_attachment_url.'" type="'.$video_content_type.'">'.trans('global.pages.frontend.home.not_support_video').'
        </video>
        </div>';
        if($course->course_videos()->count() > 1){
      $html .=  '<div class="more-videos">
            <h4>'.trans('global.pages.frontend.home.more_videos').'</h4>
            <div class="morevideos">
                <div class="mvideo-box">';
                    foreach($course->course_videos as $vkey => $video){
                        if($video->id!=$currentvideo->id){

                            $html .= '<div class="d-flex vrow" data-value="'.$video->id.'" data-course="'.$course->id.'">
                                <div class="vthumb"><img src="'.asset('images/video-thumb.jpg').'" alt=""></div>
                                <div class="vcon">
                                    <h5>'.$video->$title.'</h5>
                                    <p></p>
                                </div>
                                <div class="vbtn">
                                    <button class="playbtn" type="button"><img src="'.asset('images/playbtn.png').'"></button>
                                </div>
                            </div>';

                        }
                    }
                    
        $html .= '</div>
            </div>
        </div>';
      }

      $html .= '</div>
      <div class="modal-footer">
        <a href="'.route('takeexam', $course->id).'" class="btn btn-primary btnn">'.trans('global.pages.frontend.home.take_exam').'</a>
      </div>';
    } else {
        $html = '<div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">
        <span>'.trans('global.pages.frontend.home.course_preview').'</span>'.$course->$title.'</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="more-videos">
            <h4>'.trans('global.pages.frontend.home.no_videos_found').'</h4>
        </div>
      </div>
      <div class="modal-footer">
        <a href="'.route('takeexam', $course->id).'" class="btn btn-primary btnn">'.trans('global.pages.frontend.home.take_exam').'</a>
      </div>';
    }

    echo $html;

        //return $courses ;
         
    }

}
