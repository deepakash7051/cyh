<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
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
        
        $token = $request->all();
        
        $user = auth()->user();
        $token = $user->stripe_token()->updateOrCreate(['user_id'=>auth()->user()->id],$request->all());

        return $this->payload([
            'StatusCode' => '200', 
            'message' => 'Stripe Token', 
            'result' => array('user' => $token)
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
