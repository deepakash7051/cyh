<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseVideoRequest;
use App\Http\Requests\UpdateCourseVideoRequest;
use Freshbitsweb\Laratables\Laratables;
use Validator;
use App\Course;
use App\CourseVideo;

class CourseVideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(\Gate::allows('video_access'), 403);

        return view('admin.videos.index');
    }

    public function list()
    {
        return Laratables::recordsOf(CourseVideo::class);
    }

    public  function arrange(Request $request){
        
        $videoplaces = $request->videoplaces;
        foreach($videoplaces as $key => $value){
            CourseVideo::where('id', $value)->update(['place'=>$key+1]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort_unless(\Gate::allows('video_create'), 403);
        $courses = Course::where('status', '1')->get();
        $course_id = $request->course_id;
        return view('admin.videos.create', compact('courses', 'course_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseVideoRequest $request)
    {
        abort_unless(\Gate::allows('video_create'), 403);
        $params = $request->all();
        if($request->same_for_all=='1'){
            $params['bn_attachment'] = $request->en_attachment;
            $params['zh_attachment'] = $request->en_attachment;
            $params['ta_attachment'] = $request->en_attachment;
        }
        $videocount = CourseVideo::where('course_id', $request->course_id)->count();
        $params['place'] = $videocount+1;
        $coursevideo = CourseVideo::create($params);

        //return redirect()->route('admin.videos.index');
        return redirect()->route('admin.courses.videos', ['id' => $request->course_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_unless(\Gate::allows('video_show'), 403);

        $coursevideo = CourseVideo::find($id);
        return view('admin.videos.show', compact('coursevideo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(\Gate::allows('video_edit'), 403);
        $courses = Course::where('status', '1')->get();
        $coursevideo = CourseVideo::find($id);
        return view('admin.videos.edit', compact('coursevideo','courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourseVideoRequest $request, $id)
    {
        abort_unless(\Gate::allows('video_edit'), 403);

        $coursevideo = CourseVideo::find($id);
        $params = $request->all();
        if($request->same_for_all=='1'){
            $params['bn_attachment'] = $request->en_attachment;
            $params['zh_attachment'] = $request->en_attachment;
            $params['ta_attachment'] = $request->en_attachment;
        }
        $coursevideo->update($params);

        //return redirect()->route('admin.videos.index');
        return redirect()->route('admin.courses.videos', ['id' => $request->course_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(\Gate::allows('video_delete'), 403);

        $coursevideo = CourseVideo::find($id);
        $coursevideo->delete();

        return back();
    }
}
