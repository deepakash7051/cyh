<?php

namespace App\Http\Controllers\Api\v1;

use Validator;
use App\ManualPayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MilestoneManualPaymentController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }
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
        try{
            $validator = Validator::make($request->all(), [
	            'milestone_id' => 'required|integer',
                'attachment' => 'required',
                'attachment.*' => 'image:jpeg,png,jpg,gif,svg|max:2048'
	        ]);
	        if ($validator->fails()) {
	            $errors = $validator->errors()->toArray();
	            $message = "";
	            foreach($errors as $key  => $values){
	                foreach($values as $value){
	                    $message .= $value . "\n";
	                }
	            }
	            return $this->payload(['StatusCode' => '422', 'message' => $message, 'result' => new \stdClass],200);
	        }

            $user = auth()->user();

            $chekcManualPayment = ManualPayment::where(['milestone_payment_id'=>$request->input('milestone_payment_id'), 'user_id'=>$user->id]);
          
            $data = $request->merge(['attachment' => $request->attachment,'user_id'=>$user->id])->all();
            return $data;
            if($chekcManualPayment->exists()){
                //return $chekcManualPayment->get();
            }else{
                $payment = $proposal->manual_payment()->create($data);
                $proposal->payment_status()->updateOrCreate(['user_id'=>$user->id,'manual_payment_id'=>$payment->id,'proposal_id'=>$request->input('proposal_id'),'type'=>'manual','status'=>'pending']);
                $proposal->update(['amount'=>$request->input('amount')]);
                $this->mileston_payment($request->all());
            }
            
            return $this->payload(['StatusCode' => '200', 'message' => 'Created', 'result' => array('proposal' => [])],200);
        }catch(Exception $e) {
            return $this->payload(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass],200);
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
