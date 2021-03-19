<?php

namespace App\Http\Controllers\Api\v1;

use App\User;
use App\UserImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class UserController extends ApiController
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
        $user = auth()->user();
        if( !empty($user->user_image->attachment_url) ){
            $user->attachment_url = $user->user_image->attachment_url;
        }else{
            $user->attachment_url = "";
        }
        try{
            return $this->payload([
                'StatusCode' => '200', 
                'message' => 'User Details', 
                'result' => array('user' => $user)
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
	            'email' => 'required|string|email|max:255',
	            'name' => 'required',
	            'phone' => 'required|digits:10|integer',
	            //'role' => 'required',
                'image' => 'image:jpeg,png,jpg,gif,svg|max:2048'
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
            
            $data = [
                'name'  => $request->name,
                'email' => $request->email,
                'phone' => $request->phone
            ];

            if( !empty($request->password) ){
                $data['password'] = $request->password;
            }

            $user->update( $data );

            if( !empty($request->attachment) ){
                UserImage::updateOrCreate(['user_id' => $user->id], ['attachment' => $request->file('attachment')]);
            }
            //return $user->user_image;
            if( !empty($user->user_image) ){
                $user->attachment_url = $user->user_image->attachment_url;
            }else{
                $user->attachment_url = "";
            }
            if($user){
                return $this->payload([
                    'StatusCode' => '200', 
                    'message' => 'User Details Updated Successfully', 
                    'result' => array('user'=>$user)
                ], 200);
            }
        } catch(Exception $e) {
            return $this->payload(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass], 200);
        }
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
