<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Module;
use App\Course;
use App\CourseAttempt;
use FFMpeg\FFMpeg;

class ModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$ffmpeg = \FFMpeg\FFMpeg::create([
            'ffmpeg.binaries' => '/usr/bin/ffmpeg',
            'fprobe.binaries' => '/usr/bin/ffmpeg',
        ]);

        $video = $ffmpeg->open('http://localhost:8000/storage/App/CourseVideo/000/000/002/en_attachment/original/5c67b35650633.mp4');*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();
        $module = Module::find($id);
        $query = Module::where('course_id', $module->course_id)->where('status', '1')->where('place', '>', $module->place)->orderBy('place', 'asc');
        if($query->count() > 0){
            $resume_module = $query->first()->id;
        } else {
            $resume_module = '';
        }

        $match = array(
            'user_id' => $user->id, 
            'course_id' => $module->course_id
        );

        $attempt = CourseAttempt::updateOrCreate($match, [
            'resume_module' => $module->id
        ]);

        $course = Course::with(['modules'])->find($module->course_id);
        return view('frontend.modules.show', compact('module', 'course' , 'resume_module'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
