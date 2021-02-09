<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use Freshbitsweb\Laratables\Laratables;
use Validator;
use App\Course;
use App\Quiz;
use App\Question;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(\Gate::allows('questions_access'), 403);

        return view('admin.questions.index');
    }

    public function list()
    {
        return Laratables::recordsOf(Quiz::class);
    }

    public  function arrange(Request $request){
        
        $questionplaces = $request->questionplaces;
        foreach($questionplaces as $key => $value){
            Question::where('id', $value)->update(['place'=>$key+1]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(\Gate::allows('question_create'), 403);

        $quizzes = Quiz::where('status', '1')->get();
        return view('admin.questions.create', compact('quizzes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        abort_unless(\Gate::allows('quiz_create'), 403);
        
        $params = $request->all();
        $quiz = Quiz::find($request->quiz_id);
        $questioncount = Question::where('quiz_id', $request->quiz_id)->count();
        $params['place'] = $questioncount+1;
        $params['course_id'] = $quiz->course_id;
        $question = Question::create($params);

        //return redirect()->route('admin.quizzes.index');
        return redirect()->route('admin.quizzes.questions', ['id' => $request->quiz_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_unless(\Gate::allows('question_show'), 403);

        $question = Question::find($id);
        return view('admin.questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(\Gate::allows('question_edit'), 403);
        $quizzes = Quiz::where('status', '1')->get();
        $question = Question::find($id);
        return view('admin.questions.edit', compact('question','quizzes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionRequest $request, $id)
    {
        abort_unless(\Gate::allows('question_edit'), 403);

        $quiz = Quiz::find($request->quiz_id);
        $question = Question::find($id);
        $params = $request->all();
        $params['course_id'] = $quiz->course_id;
        $question->update($params);

        //return redirect()->route('admin.quizzes.index');
        return redirect()->route('admin.quizzes.questions', ['id' => $request->quiz_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(\Gate::allows('question_delete'), 403);

        $question = Question::find($id);
        $question->delete();

        return back();
    }
}
