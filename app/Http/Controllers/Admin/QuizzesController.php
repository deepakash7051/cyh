<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use Freshbitsweb\Laratables\Laratables;
use Validator;
use App\Course;
use App\Quiz;
use App\Question;

class QuizzesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(\Gate::allows('quiz_access'), 403);

        return view('admin.quizzes.index');
    }

    public function list()
    {
        return Laratables::recordsOf(Quiz::class);
    }

    public  function arrange(Request $request){
        
        $slideplaces = $request->slideplaces;
        foreach($slideplaces as $key => $value){
            Quiz::where('id', $value)->update(['place'=>$key+1]);
        }
    }

    public function questions(Request $resquest, $id)
    {
        abort_unless(\Gate::allows('question_access'), 403);
        abort_unless(\Gate::allows('question_edit'), 403);

        $quiz = Quiz::find($id);
        $questions =  Question::where('quiz_id', $id)->where('status', '1')->orderBy('place')->get();
        return view('admin.quizzes.questions', compact('questions', 'quiz'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(\Gate::allows('quiz_create'), 403);
        $courses = Course::where('status', '1')->get();
        return view('admin.quizzes.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuizRequest $request)
    {
        abort_unless(\Gate::allows('quiz_create'), 403);
        
        $params = $request->all();
        $quizcount = Quiz::where('course_id', $request->course_id)->count();
        $params['place'] = $quizcount+1;
        $quiz = Quiz::create($params);

        //return redirect()->route('admin.quizzes.index');
        return redirect()->route('admin.courses.quizzes', ['id' => $request->course_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_unless(\Gate::allows('quiz_show'), 403);

        $quiz = Quiz::find($id);
        return view('admin.quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(\Gate::allows('quiz_edit'), 403);
        $courses = Course::where('status', '1')->get();
        $quiz = Quiz::find($id);
        return view('admin.quizzes.edit', compact('quiz','courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuizRequest $request, $id)
    {
        abort_unless(\Gate::allows('quiz_edit'), 403);

        $quiz = Quiz::find($id);
        $params = $request->all();
        $quiz->update($params);

        //return redirect()->route('admin.quizzes.index');
        return redirect()->route('admin.courses.quizzes', ['id' => $request->course_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(\Gate::allows('quiz_delete'), 403);

        $quiz = Quiz::find($id);
        $quiz->delete();

        return back();
    }
}
