<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseSlideRequest;
use App\Http\Requests\UpdateCourseSlideRequest;
use Freshbitsweb\Laratables\Laratables;
use Validator;
use App\Course;
use App\CourseSlide;

class CourseSlidesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(\Gate::allows('slide_access'), 403);

        return view('admin.slides.index');
    }

    public function list()
    {
        return Laratables::recordsOf(CourseSlide::class);
    }

    public  function arrange(Request $request){
        
        $slideplaces = $request->slideplaces;
        foreach($slideplaces as $key => $value){
            CourseSlide::where('id', $value)->update(['place'=>$key+1]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort_unless(\Gate::allows('slide_create'), 403);
        $courses = Course::where('status', '1')->get();
        $course_id = $request->course_id;
        return view('admin.slides.create', compact('courses', 'course_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseSlideRequest $request)
    {
        abort_unless(\Gate::allows('slide_create'), 403);
        $params = $request->all();
        if($request->same_for_all=='1'){
            $params['bn_attachment'] = $request->en_attachment;
            $params['zh_attachment'] = $request->en_attachment;
            $params['ta_attachment'] = $request->en_attachment;
        }
        $slidecount = CourseSlide::where('course_id', $request->course_id)->count();
        $params['place'] = $slidecount+1;
        $courseslide = CourseSlide::create($params);

        //return redirect()->route('admin.slides.index');
        return redirect()->route('admin.courses.slides', ['id' => $request->course_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_unless(\Gate::allows('slide_show'), 403);

        $courseslide = CourseSlide::find($id);
        return view('admin.slides.show', compact('courseslide'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(\Gate::allows('slide_edit'), 403);
        $courses = Course::where('status', '1')->get();
        $courseslide = CourseSlide::find($id);
        return view('admin.slides.edit', compact('courseslide','courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourseSlideRequest $request, $id)
    {
        abort_unless(\Gate::allows('slide_edit'), 403);

        $courseslide = CourseSlide::find($id);
        $params = $request->all();
        if($request->same_for_all=='1'){
            $params['bn_attachment'] = $request->en_attachment;
            $params['zh_attachment'] = $request->en_attachment;
            $params['ta_attachment'] = $request->en_attachment;
        }
        $courseslide->update($params);

        //return redirect()->route('admin.slides.index');
        return redirect()->route('admin.courses.slides', ['id' => $request->course_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(\Gate::allows('slide_delete'), 403);

        $courseslide = CourseSlide::find($id);
        $courseslide->delete();

        return back();
    }
}
