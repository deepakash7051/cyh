<?php

namespace App\Http\Controllers\Api\v1;

use JWTAuth;
use Response;
use Validator;

use App\Design;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use JWTFactory;

class DesignController extends ApiController
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
	            'title' => 'required',
                'attachments.*' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
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

            if( $request->has('attachments') ){
                foreach($request->attachments as $attachment){
                    $user->designs()->create(['title'=>$request->input('title'), 'attachment' => $attachment]);
                    //$user->attachment_url = 'qs';
                }
            }
            $user->load(['designs']);

                return $this->payload(['StatusCode' => '200', 'message' => 'Design has been created successfully', 'result' => array('user' => $user)],200);

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
