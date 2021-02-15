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
use App\Mcqoption;

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
    public function create(Request $request)
    {
        abort_unless(\Gate::allows('question_create'), 403);

        $quizzes = Quiz::where('status', '1')->get();
        $quiz_id = $request->quiz_id;
        return view('admin.questions.create', compact('quizzes', 'quiz_id'));
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
        if($request->same_for_all=='1'){
            $params['bn_attachment'] = $request->en_attachment;
            $params['zh_attachment'] = $request->en_attachment;
            $params['ta_attachment'] = $request->en_attachment;
        }
        if($request->sameans_for_all=='1'){
            $params['bn_correct_answer'] = $request->en_correct_answer;
            $params['zh_correct_answer'] = $request->en_correct_answer;
            $params['ta_correct_answer'] = $request->en_correct_answer;
        }
        $quiz = Quiz::find($request->quiz_id);
        $questioncount = Question::where('quiz_id', $request->quiz_id)->count();
        $params['place'] = $questioncount+1;
        $params['course_id'] = $quiz->course_id;
        $question = Question::create($params);

        if($request->type=='1' && $request->visible=='text'){
            if($request->sameoption_for_all=='1'){
                //$options = [];
                $keys_a = array('en_option_a','bn_option_a','zh_option_a', 'ta_option_a');
                $options_a = array_fill_keys($keys_a, $request->en_option_a);
                $keys_b = array('en_option_b','bn_option_b','zh_option_b', 'ta_option_b');
                $options_b = array_fill_keys($keys_b, $request->en_option_b);
                $keys_c = array('en_option_c','bn_option_c','zh_option_c', 'ta_option_c');
                $options_c = array_fill_keys($keys_c, $request->en_option_c);
                $keys_d = array('en_option_d','bn_option_d','zh_option_d', 'ta_option_d');
                $options_d = array_fill_keys($keys_d, $request->en_option_d);
                
                $params = array_merge($params, $options_a, $options_b, $options_c, $options_d);
                $question->mcqoption()->create($params);

            } else {
                $question->mcqoption()->create($params);
            }
        } 

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

        $params = $request->all();
        if($request->same_for_all=='1'){
            $params['bn_attachment'] = $request->en_attachment;
            $params['zh_attachment'] = $request->en_attachment;
            $params['ta_attachment'] = $request->en_attachment;
        }
        if($request->sameans_for_all=='1'){
            $params['bn_correct_answer'] = $request->en_correct_answer;
            $params['zh_correct_answer'] = $request->en_correct_answer;
            $params['ta_correct_answer'] = $request->en_correct_answer;
        }

        $quiz = Quiz::find($request->quiz_id);
        $question = Question::find($id);
        $params = $request->all();
        $params['course_id'] = $quiz->course_id;
        $question->update($params);

        if($request->type=='1' && $request->visible=='text'){
            if($request->sameoption_for_all=='1'){
                //$options = [];
                $keys_a = array('en_option_a','bn_option_a','zh_option_a', 'ta_option_a');
                $options_a = array_fill_keys($keys_a, $request->en_option_a);
                $keys_b = array('en_option_b','bn_option_b','zh_option_b', 'ta_option_b');
                $options_b = array_fill_keys($keys_b, $request->en_option_b);
                $keys_c = array('en_option_c','bn_option_c','zh_option_c', 'ta_option_c');
                $options_c = array_fill_keys($keys_c, $request->en_option_c);
                $keys_d = array('en_option_d','bn_option_d','zh_option_d', 'ta_option_d');
                $options_d = array_fill_keys($keys_d, $request->en_option_d);
                
                $params = array_merge($params, $options_a, $options_b, $options_c, $options_d);

                $mcqoption = Mcqoption::where('question_id', $question->id);
                if($mcqoption->count() > 0){
                    $question->mcqoption->update($params);
                } else {
                    $question->mcqoption()->create($params);
                }

            } else {
                $mcqoption = Mcqoption::where('question_id', $question->id);
                if($mcqoption->count() > 0){
                    $question->mcqoption->update($params);
                } else {
                    $question->mcqoption()->create($params);
                }
            }
        }

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
