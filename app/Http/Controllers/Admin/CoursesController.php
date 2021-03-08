<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Freshbitsweb\Laratables\Laratables;
use App\Course;
use App\CourseVideo;
use App\CourseSlide;
use App\Category;
use App\Quiz;
use App\Module;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(\Gate::allows('course_access'), 403);

        return view('admin.courses.index');
    }

    public function list()
    {
        return Laratables::recordsOf(Course::class);
    }

    public function videos(Request $resquest, $id)
    {
        abort_unless(\Gate::allows('video_access'), 403);
        abort_unless(\Gate::allows('video_edit'), 403);

        $course = Course::find($id);
        $coursevideos =  CourseVideo::where('course_id', $id)->orderBy('place')->get();
        return view('admin.courses.videos', compact('coursevideos', 'course'));
    }

    public function slides(Request $resquest, $id)
    {
        abort_unless(\Gate::allows('slide_access'), 403);
        abort_unless(\Gate::allows('slide_edit'), 403);

        $course = Course::find($id);
        $courseslides =  CourseSlide::where('course_id', $id)->orderBy('place')->get();
        return view('admin.courses.slides', compact('courseslides', 'course'));
    }

    public function quizzes(Request $resquest, $id)
    {
        abort_unless(\Gate::allows('quiz_access'), 403);
        abort_unless(\Gate::allows('quiz_edit'), 403);

        $course = Course::with(['quiz'])->find($id);
        $quizzes =  Quiz::where('course_id', $id)->orderBy('place')->get();
        return view('admin.courses.quizzes', compact('quizzes', 'course'));
    }

    public function modules(Request $resquest, $id)
    {
        abort_unless(\Gate::allows('module_access'), 403);
        abort_unless(\Gate::allows('module_edit'), 403);

        $course = Course::find($id);
        $modules =  Module::where('course_id', $id)->orderBy('place')->get();
        return view('admin.courses.modules', compact('modules', 'course'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(\Gate::allows('course_create'), 403);

        $categories = Category::where('status', 1)->get();
        return view('admin.courses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseRequest $request)
    {
        abort_unless(\Gate::allows('course_create'), 403);

        $course = Course::create($request->all());

        return redirect()->route('admin.courses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_unless(\Gate::allows('course_show'), 403);

        $course = Course::find($id);
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(\Gate::allows('course_edit'), 403);
        $course = Course::find($id);
        $categories = Category::where('status', 1)->get();
        return view('admin.courses.edit', compact('course', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourseRequest $request, $id)
    {
        abort_unless(\Gate::allows('course_edit'), 403);

        $course = Course::find($id);
        $course->update($request->all());

        return redirect()->route('admin.courses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(\Gate::allows('course_delete'), 403);

        $course = Course::find($id);
        $course->delete();

        return back();
    }
}
