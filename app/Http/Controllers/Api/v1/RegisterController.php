<?php

namespace App\Http\Controllers\Api\v1;

use JWTAuth;
use App\User;

use Response;
use Validator;

use JWTFactory;
use App\RoleUser;
use App\UserImage;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Api\v1\ApiController;

class RegisterController extends ApiController
{
	public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    { 
        try{
	        $validator = Validator::make($request->all(), [
	            'email' => 'required|string|email|max:255',
	            'name' => 'required',
	            'phone' => 'required|digits:10|integer',
	            'password'=> 'required',
	            'role' => 'required',
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

			$checkExistEmail = User::where('email', $request->email)->whereNull('deleted_at')->first();
	        if(!empty($checkExistEmail)){
	            return $this->payload(['StatusCode' => '422', 'message' => 'Email already exist', 'result' => new \stdClass],201);
	        }

	        $checkExistPhone = User::where('phone', $request->phone)->whereNull('deleted_at')->first();
	        if(!empty($checkExistPhone)){
	            return $this->payload(['StatusCode' => '422', 'message' => 'Phone number already exist', 'result' => new \stdClass],201);
	        }

	        $user = User::create([
	            'name' => $request->get('name'),
	            'email' => $request->get('email'),
	            'phone' => $request->get('phone'),
	            'password' => bcrypt($request->get('password')),
	            'isd_code' => $request->get('isd_code')
	        ]);
	       
            if($request->file('attachment')){

                $user->user_image()->create(['attachment' => $request->file('attachment')]);
                
            }
            // $user->sendEmailVerificationNotification();
            
	        $role = RoleUser::create([
	            'user_id' => $user->id,
	            'role_id' => $request->get('role')
	        ]);

	        $token = JWTAuth::fromUser($user);

	        $user->token = $token;
            $user->load(['user_image']);

	        return $this->payload(['StatusCode' => '200', 'message' => 'Register successful and Email verification link sent on your email id', 'result' => array('user' => $user)],200);
        } catch(Exception $e) {
            return $this->payload(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass],200);
        }
    }

    public function refresh($token = null){
         $token = $token ? $token : JWTAuth::getToken();
         if(!$token){
            return $this->payload(['StatusCode' => '422', 'message' => 'Token not provided', 'result' => new \stdClass],201);
         }
         try{
             $token = JWTAuth::refresh($token);
         }catch(TokenInvalidException $e){
            return $this->payload(['StatusCode' => '422', 'message' => 'The token is invalid', 'result' => new \stdClass],201);
         }

         $user = JWTAuth::user();
         $user = $user->load(['roles', 'user_detail']);
         $user->token = $token;
         return $this->payload([
            'StatusCode' => '200',
            'message' => 'Token refresh successfully',
            'result' => array('user' => $user)
        ],200);
    }

    public function editprofile(Request $request){
    	try {
    	$user = JWTAuth::user();

    	$validator = Validator::make($request->all(), [
            'name' => 'required',
            'pin' => 'min:4|digits:4|integer',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'digits:10|integer|unique:users,phone,'.$user->id,
        ]);

        $validator->sometimes(['password_confirmation'], 'required_with:password|same:password', function ($input) {
            return !empty($input->password);
        });

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

        $is_phone_verified = $user->phone==$request->phone ? '1' : '0';
        $params = $request->all();
        $params['is_phone_verified'] = $is_phone_verified;
        if($user->email!=$request->email){
        	$params['email_verified_at'] = '';
        }
        if(!empty($request->password)){
        	$params['password'] = bcrypt($request->get('password'));
        }
        $user->fill($params);
        $user = $user->load(['roles', 'user_detail']);
        $update = $user->save();
        
        if($user->email!=$request->email){
        	$user->sendEmailVerificationNotification();
        }

        if($update){
            return $this->payload(['StatusCode' => '200', 'message' => 'Details updated successfully', 'result' => array('user' => $user)],200);
        } else {
            return $this->payload(['StatusCode' => '200', 'message' => 'Details not updated', 'result' => array('user' => $user)],200);
        }

        }catch(TokenInvalidException $e){
            return $this->payload(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass],200);
        }

    }

    public function setpin(Request $request){
        $user = JWTAuth::user();

        $validator = Validator::make($request->all(), [
            'pin' => 'required|min:4|digits:4|integer',
        ]);

        $validator->sometimes(['password_confirmation'], 'required_with:password|same:password', function ($input) {
            return !empty($input->password);
        });

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

        $user->fill($request->all());
        $user = $user->load(['roles', 'user_detail']);
        $update = $user->save();

        if($update){
            return $this->payload(['StatusCode' => '200', 'message' => 'Pin set successfully', 'result' => array('user' => $user)],200);
        } else {
            return $this->payload(['StatusCode' => '200', 'message' => 'Pin not updated', 'result' => array('user' => $user)],200);
        }
    }
}
