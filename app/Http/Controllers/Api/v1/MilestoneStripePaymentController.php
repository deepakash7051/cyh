<?php

namespace App\Http\Controllers\Api\v1;

use Validator;
use Stripe\Charge;
use Stripe\Stripe;
use App\MilestonePayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MilestoneStripePaymentController extends ApiController
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
            $milestone = MilestonePayment::with(['milestone'])->where(['id'=>$request->input('milestone_id')]);
            if($milestone->exists()){
                
                $details = $milestone->first();

                if( $details->status == 'unpaid' ){
                    $payment = '';
                    $token = $request->all();

                    $data = [
                        "amount" => (int)$details->amount * 100,
                        "currency" => "inr",
                        "source" => $request->input('token'),
                        "description" => "Payment for Milestone ".$details->milestone->title." has been completed."
                    ];

                    Stripe::setApiKey(env('STRIPE_SECRET'));

                    $payment = Charge::create ($data);

                    if($payment){
                        $data = [
                            'proposal_id' => $details->proposal_id,
                            'transaction_id' => $payment->id,
                            'amount' => $payment->amount,
                            'object' => $payment->object,
                            'balance_transaction' => $payment->balance_transaction,
                            'status' => $payment->status,
                            'paid'=>$payment->paid
                        ];
                        $sId = $user->stripe_payment()->create($data);
                        $milestone->update(['status'=>'paid']);
                    }

                    return $data;
                }else{
                    //return 2222222;
                }
            }else{
                //return 222222;
            }
            return $this->payload(['StatusCode' => '200', 'message' => 'Created', 'result' => array('milestone_payment' => [])],200);
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
