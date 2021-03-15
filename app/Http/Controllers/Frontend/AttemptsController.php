<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\QuizAttempt;
use App\CourseAttempt;
use App\Question;
use App\Quiz;
use App\Module;

class AttemptsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $user = auth()->user();
        $params = $request->all();
        unset($params['quiz_id']);
        unset($params['_token']);

        $attempt = QuizAttempt::create([
            'user_id' => $user->id,
            'quiz_id' => $request->quiz_id,
            'attempt_result' => json_encode($params)
        ]);

        $quiz = Quiz::find($request->quiz_id);

        $score = 0;
        $total = count($params);
        $correct_answer = config('app.locale').'_correct_answer';
        foreach ($params as $key => $value) {
            $ques = explode('_', $key);
            $question = Question::find($ques[1]);
            $answer = trim($value);
            if(strtolower($answer)== strtolower($question->$correct_answer)){
                $score++;
            }
        }

        if($score==$total){
            CourseAttempt::where('user_id', $user->id)->where('course_id', $quiz->course_id)->update(['completed_at' => date('Y-m-d H:i:s')]);
        }

        if(!empty($quiz->module_id)){
            $module = Module::find($quiz->module_id);
            $query = Module::where('course_id', $module->course_id)->where('status', '1')->where('place', '>', $module->place)->orderBy('place', 'asc');
            if($query->count() > 0){
                $resume_module = $query->first()->id;
            } else {
                $resume_module = '';
            }
            $finalquiz = Quiz::where('course_id', $module->course_id)->first();
        } else {
             $finalquiz = $quiz;
             $resume_module = '';
        }


        if($attempt){
            return view('frontend.exams.scores', compact('quiz', 'score', 'total', 'resume_module', 'finalquiz'));
            
        } else {
            return redirect('/home')->with('error', trans('global.error_message'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
