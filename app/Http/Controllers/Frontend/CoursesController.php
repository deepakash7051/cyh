<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\CourseAttempt;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $course = Course::with(['modules'])->find($id);
        $query = CourseAttempt::where('course_id', $id)->where('user_id', $user->id);
        if($query->count() > 0){
            $resume_module = $query->first()->resume_module;
        } else {
            if($course->modules->count() > 0){
                $resume_module = $course->modules()->first()->id;
            } else {
                $resume_module = '';
            }
        }

        return view('frontend.courses.show', compact('course', 'resume_module'));
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

    public function attemptcourse(Request $request){
        $user = auth()->user();
        $match = array(
            'user_id' => $user->id, 
            'course_id' => $request->course_id
        );

        $attempt = CourseAttempt::updateOrCreate($match, [
            'resume_module' => $request->resume_module
        ]);

        return redirect()->route('modules.show', $request->resume_module);
    }

    public function examrules($id){
        $user = auth()->user();
        $course = Course::find($id);

        return view('frontend.exams.rules', compact('course'));
    }
}
