<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreModuleRequest;
use App\Http\Requests\UpdateModuleRequest;
use Freshbitsweb\Laratables\Laratables;
use Validator;
use App\Quiz;
use App\Module;
use App\Course;

class ModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(\Gate::allows('module_access'), 403);

        return view('admin.modules.index');
    }

    public function list()
    {
        return Laratables::recordsOf(Module::class);
    }

    public  function arrange(Request $request){
        
        $moduleplaces = $request->moduleplaces;
        foreach($moduleplaces as $key => $value){
            Module::where('id', $value)->update(['place'=>$key+1]);
        }
    }

    public function quizzes(Request $request, $id)
    {
        abort_unless(\Gate::allows('quiz_access'), 403);
        abort_unless(\Gate::allows('quiz_edit'), 403);

        $module = Module::with(['quiz'])->find($id);
        $quizzes =  Quiz::where('module_id', $id)->orderBy('place')->get();
        return view('admin.modules.quizzes', compact('quizzes', 'module'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort_unless(\Gate::allows('module_create'), 403);
        $courses = Course::where('status', '1')->get();
        $course_id = $request->course_id;
        return view('admin.modules.create', compact('courses', 'course_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreModuleRequest $request)
    {
        abort_unless(\Gate::allows('module_create'), 403);
        $params = $request->all();
        if($request->same_video_for_all=='1'){
            $params['bn_video'] = $request->en_video;
            $params['zh_video'] = $request->en_video;
            $params['ta_video'] = $request->en_video;

            $params['bn_video_link'] = $request->en_video_link;
            $params['zh_video_link'] = $request->en_video_link;
            $params['ta_video_link'] = $request->en_video_link;
        }
        if($request->same_slide_for_all=='1'){
            $params['bn_slide'] = $request->en_slide;
            $params['zh_slide'] = $request->en_slide;
            $params['ta_slide'] = $request->en_slide;
        }
        $modulecount = Module::where('course_id', $request->course_id)->count();
        $params['place'] = $modulecount+1;
        $module = Module::create($params);

        //return redirect()->route('admin.videos.index');
        return redirect()->route('admin.courses.modules', ['id' => $request->course_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_unless(\Gate::allows('module_show'), 403);

        $module = Module::find($id);
        return view('admin.modules.show', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(\Gate::allows('module_edit'), 403);
        $courses = Course::where('status', '1')->get();
        $module = Module::find($id);
        return view('admin.modules.edit', compact('courses', 'module'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateModuleRequest $request, $id)
    {
        abort_unless(\Gate::allows('module_create'), 403);
        $module = Module::find($id);
        $params = $request->all();
        if($request->same_video_for_all=='1'){
            $params['bn_video'] = $request->en_video;
            $params['zh_video'] = $request->en_video;
            $params['ta_video'] = $request->en_video;

            $params['bn_video_link'] = $request->en_video_link;
            $params['zh_video_link'] = $request->en_video_link;
            $params['ta_video_link'] = $request->en_video_link;
        }
        if($request->same_slide_for_all=='1'){
            $params['bn_slide'] = $request->en_slide;
            $params['zh_slide'] = $request->en_slide;
            $params['ta_slide'] = $request->en_slide;
        }
        $module->update($params);

        //return redirect()->route('admin.videos.index');
        return redirect()->route('admin.courses.modules', ['id' => $request->course_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(\Gate::allows('module_delete'), 403);

        $module = Module::find($id);
        $module->delete();

        return back();
    }
}
