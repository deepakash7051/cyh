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

        if($request->type=='0'){
            if($request->sametextans_for_all=='1'){
                $params['bn_correct_answer'] = $request->en_correct_answer;
                $params['zh_correct_answer'] = $request->en_correct_answer;
                $params['ta_correct_answer'] = $request->en_correct_answer;
            }
        } else {
            if($request->samemcqans_for_all=='1'){
                $params['en_correct_answer'] = $request->en_mcqcorrect_answer;
                $params['bn_correct_answer'] = $request->en_mcqcorrect_answer;
                $params['zh_correct_answer'] = $request->en_mcqcorrect_answer;
                $params['ta_correct_answer'] = $request->en_mcqcorrect_answer;
            } else {
                $params['en_correct_answer'] = $request->en_mcqcorrect_answer;
                $params['bn_correct_answer'] = $request->bn_mcqcorrect_answer;
                $params['zh_correct_answer'] = $request->zh_mcqcorrect_answer;
                $params['ta_correct_answer'] = $request->ta_mcqcorrect_answer;
            }
        }

        
        $quiz = Quiz::find($request->quiz_id);
        $questioncount = Question::where('quiz_id', $request->quiz_id)->count();
        $params['place'] = $questioncount+1;
        $params['course_id'] = $quiz->course_id;
        $question = Question::create($params);

        $languages = config('panel.available_languages');
        if(count($languages) > 0){
            if($request->type=='1'){
                if($request->option_label=='text'){
                    if($request->sametextoption_for_all=='1'){
                        foreach($languages as $key => $val){
                            $question->mcqoptions()->create(['type' => 'text', 'language' => $key, 'option' => 'a', 'value' => $request->en_option_a]);
                            $question->mcqoptions()->create(['type' => 'text', 'language' => $key, 'option' => 'b', 'value' => $request->en_option_b]);
                            $question->mcqoptions()->create(['type' => 'text', 'language' => $key, 'option' => 'c', 'value' => $request->en_option_c]);
                            $question->mcqoptions()->create(['type' => 'text', 'language' => $key, 'option' => 'd', 'value' => $request->en_option_d]);
                        }
                    } else {
                        foreach($languages as $key => $val){
                            $option_a = $key.'_option_a';
                            $option_b = $key.'_option_b';
                            $option_c = $key.'_option_c';
                            $option_d = $key.'_option_d';
                            $question->mcqoptions()->create(['type' => 'text', 'language' => $key, 'option' => 'a', 'value' => $request->$option_a]);
                            $question->mcqoptions()->create(['type' => 'text', 'language' => $key, 'option' => 'b', 'value' => $request->$option_b]);
                            $question->mcqoptions()->create(['type' => 'text', 'language' => $key, 'option' => 'c', 'value' => $request->$option_c]);
                            $question->mcqoptions()->create(['type' => 'text', 'language' => $key, 'option' => 'd', 'value' => $request->$option_d]);
                        }
                    }
                } else {
                    if($request->sameimgoption_for_all=='1'){
                        foreach($languages as $key => $val){
                            $question->mcqoptions()->create(['type' => 'text', 'language' => $key, 'option' => 'a', 'attachment' => $request->en_option_attachment_a]);
                            $question->mcqoptions()->create(['type' => 'text', 'language' => $key, 'option' => 'b', 'attachment' => $request->en_option_attachment_b]);
                            $question->mcqoptions()->create(['type' => 'text', 'language' => $key, 'option' => 'c', 'attachment' => $request->en_option_attachment_c]);
                            $question->mcqoptions()->create(['type' => 'text', 'language' => $key, 'option' => 'd', 'attachment' => $request->en_option_attachment_d]);
                        }
                    } else {
                        foreach($languages as $key => $val){
                            $option_a = $key.'_option_attachment_a';
                            $option_b = $key.'_option_attachment_b';
                            $option_c = $key.'_option_attachment_c';
                            $option_d = $key.'_option_attachment_d';
                            $question->mcqoptions()->create(['type' => 'text', 'language' => $key, 'option' => 'a', 'attachment' => $request->$option_a]);
                            $question->mcqoptions()->create(['type' => 'text', 'language' => $key, 'option' => 'b', 'attachment' => $request->$option_b]);
                            $question->mcqoptions()->create(['type' => 'text', 'language' => $key, 'option' => 'c', 'attachment' => $request->$option_c]);
                            $question->mcqoptions()->create(['type' => 'text', 'language' => $key, 'option' => 'd', 'attachment' => $request->$option_d]);
                        }
                    }
                }
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

        /*echo '<pre>';
        print_r($params);
        exit();*/

        if($request->same_for_all=='1'){
            $params['bn_attachment'] = $request->en_attachment;
            $params['zh_attachment'] = $request->en_attachment;
            $params['ta_attachment'] = $request->en_attachment;
        }
        if($request->type=='0'){
            if($request->sametextans_for_all=='1'){
                $params['bn_correct_answer'] = $request->en_correct_answer;
                $params['zh_correct_answer'] = $request->en_correct_answer;
                $params['ta_correct_answer'] = $request->en_correct_answer;
            }
        } else {
            if($request->samemcqans_for_all=='1'){
                $params['en_correct_answer'] = $request->en_mcqcorrect_answer;
                $params['bn_correct_answer'] = $request->en_mcqcorrect_answer;
                $params['zh_correct_answer'] = $request->en_mcqcorrect_answer;
                $params['ta_correct_answer'] = $request->en_mcqcorrect_answer;
            } else {
                $params['en_correct_answer'] = $request->en_mcqcorrect_answer;
                $params['bn_correct_answer'] = $request->bn_mcqcorrect_answer;
                $params['zh_correct_answer'] = $request->zh_mcqcorrect_answer;
                $params['ta_correct_answer'] = $request->ta_mcqcorrect_answer;
            }
        }

        $quiz = Quiz::find($request->quiz_id);
        $question = Question::find($id);
        $params = $request->all();
        $params['course_id'] = $quiz->course_id;
        $question->update($params);

        $languages = config('panel.available_languages');
        if(count($languages) > 0){
            if($request->type=='1'){
                if($request->option_label=='text'){
                    if($request->sametextoption_for_all=='1'){
                        foreach($languages as $key => $val){
                            $match_a = array('question_id' => $question->id, 'language' => $key, 'option' => 'a');
                            Mcqoption::updateOrCreate($match_a, [
                                'type' => 'text',
                                'value' => $request->en_option_a, 
                            ]);

                            $match_b = array('question_id' => $question->id, 'language' => $key, 'option' => 'b');
                            Mcqoption::updateOrCreate($match_b, [
                                'type' => 'text',
                                'value' => $request->en_option_b, 
                            ]);

                            $match_c = array('question_id' => $question->id, 'language' => $key, 'option' => 'c');
                            Mcqoption::updateOrCreate($match_c, [
                                'type' => 'text',
                                'value' => $request->en_option_c, 
                            ]);

                            $match_d = array('question_id' => $question->id, 'language' => $key, 'option' => 'd');
                            Mcqoption::updateOrCreate($match_d, [
                                'type' => 'text',
                                'value' => $request->en_option_d, 
                            ]);

                        }
                    } else {
                        foreach($languages as $key => $val){
                            $option_a = $key.'_option_a';
                            $option_b = $key.'_option_b';
                            $option_c = $key.'_option_c';
                            $option_d = $key.'_option_d';

                            $match_a = array('question_id' => $question->id, 'language' => $key, 'option' => 'a');
                            Mcqoption::updateOrCreate($match_a, [
                                'type' => 'text',
                                'value' => $request->$option_a, 
                            ]);

                            $match_b = array('question_id' => $question->id, 'language' => $key, 'option' => 'b');
                            Mcqoption::updateOrCreate($match_b, [
                                'type' => 'text',
                                'value' => $request->$option_b, 
                            ]);

                            $match_c = array('question_id' => $question->id, 'language' => $key, 'option' => 'c');
                            Mcqoption::updateOrCreate($match_c, [
                                'type' => 'text',
                                'value' => $request->$option_c, 
                            ]);

                            $match_d = array('question_id' => $question->id, 'language' => $key, 'option' => 'd');
                            Mcqoption::updateOrCreate($match_d, [
                                'type' => 'text',
                                'value' => $request->$option_d, 
                            ]);

                        }
                    }
                } else {
                    if($request->sameimgoption_for_all=='1'){
                        foreach($languages as $key => $val){
                            $match_a = array('question_id' => $question->id, 'language' => $key, 'option' => 'a');
                            Mcqoption::updateOrCreate($match_a, [
                                'type' => 'text',
                                'attachment' => $request->en_option_attachment_a, 
                            ]);

                            $match_b = array('question_id' => $question->id, 'language' => $key, 'option' => 'b');
                            Mcqoption::updateOrCreate($match_b, [
                                'type' => 'text',
                                'attachment' => $request->en_option_attachment_b, 
                            ]);

                            $match_c = array('question_id' => $question->id, 'language' => $key, 'option' => 'c');
                            Mcqoption::updateOrCreate($match_c, [
                                'type' => 'text',
                                'attachment' => $request->en_option_attachment_c, 
                            ]);

                            $match_d = array('question_id' => $question->id, 'language' => $key, 'option' => 'd');
                            Mcqoption::updateOrCreate($match_d, [
                                'type' => 'text',
                                'attachment' => $request->en_option_attachment_d, 
                            ]);

                            
                        }
                    } else {
                        foreach($languages as $key => $val){
                            $option_a = $key.'_option_attachment_a';
                            $option_b = $key.'_option_attachment_b';
                            $option_c = $key.'_option_attachment_c';
                            $option_d = $key.'_option_attachment_d';

                            $match_a = array('question_id' => $question->id, 'language' => $key, 'option' => 'a');
                            Mcqoption::updateOrCreate($match_a, [
                                'type' => 'text',
                                'attachment' => $request->$option_a, 
                            ]);

                            $match_b = array('question_id' => $question->id, 'language' => $key, 'option' => 'b');
                            Mcqoption::updateOrCreate($match_b, [
                                'type' => 'text',
                                'attachment' => $request->$option_b, 
                            ]);

                            $match_c = array('question_id' => $question->id, 'language' => $key, 'option' => 'c');
                            Mcqoption::updateOrCreate($match_c, [
                                'type' => 'text',
                                'attachment' => $request->$option_c, 
                            ]);

                            $match_d = array('question_id' => $question->id, 'language' => $key, 'option' => 'd');
                            Mcqoption::updateOrCreate($match_d, [
                                'type' => 'text',
                                'attachment' => $request->$option_d, 
                            ]);

                        }
                    }
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
