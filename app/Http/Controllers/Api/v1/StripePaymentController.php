<?php

namespace App\Http\Controllers\Api\v1;

use Session;
use App\Proposal;

use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StripePaymentController extends ApiController
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
        $stripe = new StripeClient(env('STRIPE_SECRET'));
          $data = $stripe->tokens->create([
            'card' => [
              'number' => '4242424242424242',
              'exp_month' => 4,
              'exp_year' => 2022,
              'cvc' => '314',
            ],
          ]);
          return $data;
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
                $user = auth()->user();
                $token = $user->stripe_token()->first();
                
                $data = [
                    "amount" => $token->amount * 100,
                    "currency" => "inr",
                    "source" => $token->token,
                    "description" => ""
                ];

                Stripe::setApiKey(env('STRIPE_SECRET'));

                $payment = Charge::create ($data);
                $proposal = Proposal::find($token->proposal_id);
                if($payment){
                    $data = [
                        'proposal_id' => $token->proposal_id,
                        'transaction_id' => $payment->id,
                        'amount' => $payment->amount,
                        'object' => $payment->object,
                        'balance_transaction' => $payment->balance_transaction,
                        'status' => $payment->status,
                        'paid'=>$payment->paid
                    ];
                    $sId = $user->stripe_payment()->create($data);
                    $proposal->payment_status()->updateOrCreate(['user_id'=>$user->id,'s_id'=>$sId->id,'proposal_id'=>$token->proposal_id,'type'=>'stripe','status'=>'completed']);
                }
                return $this->payload(['StatusCode' => '200', 'message' => 'Payment successfully made', 'result' => array('stripe' => $payment)],200);
            } catch(Exception $e) {
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
