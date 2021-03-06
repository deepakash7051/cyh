<?php

namespace App\Http\Controllers\Api\v1;

use Validator;
use App\Proposal;
use Stripe\Charge;
use Stripe\Stripe;
use App\StripeToken;
use App\StripePayment;
use App\MilestonePayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StripeTokenController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
	        
        $token = StripeToken::all();
        return $this->payload([
            'StatusCode' => '200', 
            'message' => 'Stripe Token', 
            'result' => array('stripe' => $token)
        ], 200);

        } catch(Exception $e) {
            return $this->payload(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass], 200);
        }
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
	            'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
	            'proposal_id' => 'required|integer',
                'token' => 'required'
	        ]);

	        if ($validator->fails()) {
	            return $this->payload([
	                'StatusCode' => '422', 
	                'message' => $validator->errors(), 
	                'result' => new \stdClass
	            ], 200);
	        }
        $payment = '';
        $token = $request->all();
        
        $user = auth()->user();
        //$token = $user->stripe_token()->updateOrCreate(['user_id'=>auth()->user()->id],$request->all());
        $data = [
            "amount" => $request->input('amount') * 100,
            "currency" => "inr",
            "source" => $request->input('token'),
            "description" => "Proposal #".$request->input('proposal_id')." has been purchased."
        ];

        $chekcPayment = StripePayment::where(['proposal_id'=>$request->input('proposal_id'), 'user_id'=>$user->id]);
        
        $proposal = Proposal::find($request->input('proposal_id'));
        
        if(!$proposal){
            return $this->payload([
                'StatusCode' => '200', 
                'message' => 'Proposal does not exist.', 
                'result' => array('stripe' => '')
            ], 200);
        }

        if($chekcPayment->exists()){
            //return $chekcPayment->get();
        }else{
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $payment = Charge::create ($data);

            if($payment){
                $data = [
                    'proposal_id' => $request->input('proposal_id'),
                    'transaction_id' => $payment->id,
                    'amount' => $payment->amount,
                    'object' => $payment->object,
                    'balance_transaction' => $payment->balance_transaction,
                    'status' => $payment->status,
                    'paid'=>$payment->paid
                ];
                $sId = $user->stripe_payment()->create($data);
                $proposal->payment_status()->updateOrCreate(['user_id'=>$user->id,'s_id'=>$sId->id,'proposal_id'=>$request->input('proposal_id'),'type'=>'stripe','status'=>'completed']);
                $proposal->update(['amount'=>$request->input('amount')]);
                $this->mileston_payment($token);
            }
        }

        return $this->payload([
            'StatusCode' => '200', 
            'message' => 'Stripe', 
            'result' => array('stripe' => $payment)
        ], 200);
        
        } catch(Exception $e) {
            return $this->payload(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass], 200);
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
        try{
            $user = auth()->user();
            return $this->payload([
                'StatusCode' => '200', 
                'message' => 'Stripe Token', 
                'result' => array('stripe' => $user->stripe_token()->first())
            ], 200);
        }catch(Exception $e){   
            return $this->payload(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass], 200);
        }
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

    public function mileston_payment($request){
        MilestonePayment::create( [
            'user_id'=>auth()->user()->id,
            'proposal_id'=>$request['proposal_id'],
            'milestone_id'=>1,
            'status'=>'paid',
            'task'=>'pending',
            'amount'=>$request['amount']
        ]);

        MilestonePayment::create( [
            'user_id'=>auth()->user()->id,
            'proposal_id'=>$request['proposal_id'],
            'milestone_id'=>2,
            'status'=>'unpaid',
            'task'=>'pending',
            'amount'=>NULL
        ]);

        MilestonePayment::create( [
            'user_id'=>auth()->user()->id,
            'proposal_id'=>$request['proposal_id'],
            'milestone_id'=>3,
            'status'=>'unpaid',
            'task'=>'pending',
            'amount'=>NULL
        ]);

        MilestonePayment::create( [
            'user_id'=>auth()->user()->id,
            'proposal_id'=>$request['proposal_id'],
            'milestone_id'=>4,
            'status'=>'unpaid',
            'task'=>'pending',
            'amount'=>NULL
        ]);

        MilestonePayment::create( [
            'user_id'=>auth()->user()->id,
            'proposal_id'=>$request['proposal_id'],
            'milestone_id'=>5,
            'status'=>'unpaid',
            'task'=>'pending',
            'amount'=>NULL
        ]);

        return true;
    }
}
