<?php

namespace App\Http\Controllers\Api\v1;

use Validator;
use App\ProposalAccept;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProposalAcceptController extends ApiController
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
        return $this->payload(['StatusCode' => '200', 'message' => 'Proposal Accepted', 'result' => array('proposal_accept' => ProposalAccept::all())],200);
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
	            'admin_proposal_id' => 'required|integer',
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

            $checkProposalId =  ProposalAccept::where(['user_id'=>auth()->user()->id,'admin_proposal_id'=>$request->input('admin_proposal_id')]);
            
            $checkuserId = ProposalAccept::where(['user_id'=>auth()->user()->id]);
            //return $request->all() ;
            if(!$checkProposalId->exists() && !$checkuserId->exists() ){
                
                $checkProposalId->create(['user_id'=>$user->id,'admin_proposal_id'=>$request->input('admin_proposal_id')]);
            }

            return $this->payload(['StatusCode' => '200', 'message' => 'Proposal Accepted', 'result' => array('proposal' => [])],200);
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