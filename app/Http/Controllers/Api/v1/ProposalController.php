<?php

namespace App\Http\Controllers\Api\v1;

use JWTAuth;
use Response;
use Validator;

use App\Proposal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PortfolioResource;

class ProposalController extends ApiController
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
        try{
            $user = auth()->user();
            $proposal = $user->proposal()->with(['user','admin_proposals','portfolio','proposal_images','payment_status:id,proposal_id,status,type'])->latest()->get();
            //return $proposal;
            $resp = PortfolioResource::collection($proposal);

            return $this->payload(['StatusCode' => '200', 'message' => 'Proposal List', 'result' => array('proposal' => $proposal)],200);
        }catch(Exception $e){
            return $this->payload(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass],200);
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
	            'portfolio_id' => 'required|integer',
                'attachments.*' => 'image:jpeg,png,jpg,gif,svg|max:2048',
	            //'description' => 'required'
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

            $proposal_id = $user->proposal()->create($request->all())->id;
            
                if( $request->has('attachment') ){
                    foreach($request->attachment as $attachment){
                        $user->proposal_images()->create(['proposal_id'=>$proposal_id,'attachment' => $attachment]);
                    }
                }

            $proposal = Proposal::with([ 'proposal_images:id,proposal_id,attachment_file_name'])->where('id',$proposal_id)->get();
            
            return $this->payload(['StatusCode' => '200', 'message' => 'Proposal has been created successfully', 'result' => array('proposal' => $proposal)],200);
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
        try{
            
            $proposal = Proposal::with(['user','admin_proposals','portfolio','proposal_images','single_manual_payment','stripe_payment','payment_status:id,proposal_id,status,type'])->where('id',$id)->first();
            //return $proposal;
            $resp = new PortfolioResource($proposal);

            return $this->payload(['StatusCode' => '200', 'message' => 'Proposal List', 'result' => array('proposal' => $proposal)],200);
        }catch(Exception $e){
            return $this->payload(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass],200);
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
}
