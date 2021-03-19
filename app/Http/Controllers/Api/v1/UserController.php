<?php

namespace App\Http\Controllers\Api\v1;

use App\User;
use App\UserImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
                'result' => $user
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
    public function update(Request $request, $id)
    {
        try{
            $user = User::where('id',$id)->first();
            $user->update( $request->all() );

            if( !empty($request->attachment) ){
                UserImage::updateOrCreate(['user_id' => $user->id], ['attachment' => $request->file('attachment')]);
            }

            if($user){
                return $this->payload([
                    'StatusCode' => '200', 
                    'message' => 'User Details Updated Successfully', 
                    'result' => ''
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
