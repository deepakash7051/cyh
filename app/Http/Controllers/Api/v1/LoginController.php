<?php

namespace App\Http\Controllers\Api\v1;

use JWTAuth;
use App\User;

use Response;
use Validator;
use JWTFactory;

use App\PinReset;
use App\RoleUser;
use Notification;

use App\Http\Requests;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Notifications\ForgotPin;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Controllers\Api\v1\ApiController;

class LoginController extends ApiController
{
    protected $uploadPath;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'forgotpassword']]);
        $this->uploadPath = URL::to('/').Storage::url('users/');
    }

    public function login(Request $request){
        try{
	        $validator = Validator::make($request->all(), [
	            'email' => 'required|string|email|max:255',
	            'password'=> 'required'
	        ]);

	        if ($validator->fails()) {
	            return $this->payload([
	                'StatusCode' => '422', 
	                'message' => $validator->errors(), 
	                'result' => new \stdClass
	            ], 200);
	        }
        $credentials = $request->only('email', 'password');
        //$credentials = $request->only('phone', 'password');
        //$device_token = $request->device_token;
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->payload([
                    'StatusCode' => '401', 
                    'message' => 'Invalid credentials',
                    'result' => new \stdClass
                ], 200);
            }
        } catch (JWTException $e) {
            return $this->payload([
                'StatusCode' => '500',
                'message' => 'Could not create token', 
                'result' => new \stdClass
             ], 200);
        }

        $user = JWTAuth::user();

        // if (!$user->hasVerifiedEmail()) { 
        //     $user->sendEmailVerificationNotification();
        //     return response()->json([
        //         'StatusCode' => '500',
        //         'message' => 'Email verification link sent on your email id',
        //         'result' => new \stdClass
        //     ],200);
        // }
        
            $user->token = $token;
            $total_login = $user->total_login + 1;
            $user->total_login = $total_login;
            $user->last_login = date('Y-m-d H:i:s');
            $user->load(['user_image']);

        return $this->payload([
            'StatusCode' => '200', 
            'message' => 'Login successful!', 
            'result' => array('user' => $user)
        ], 200);

        } catch(Exception $e) {
            return $this->payload(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass], 200);
        }
    }

    public function logout(Request $request){
        $user = JWTAuth::user();
        $id = $user->id;
        JWTAuth::invalidate();
        return $this->payload([
            'StatusCode' => '200',
            'message' => 'Logged out Successfully.',
            'result' => new \stdClass
        ], 200);
        
    }

    public function forgotpassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return $this->payload([
                'StatusCode' => '422', 
                'message' => $validator->errors(), 
                'result' => new \stdClass
            ], 200);
        }
        

        try {
            $response = Password::sendResetLink($request->only('email'), function (Message $message) {
                $message->subject($this->getEmailSubject());
            });
            switch ($response) {
                case Password::RESET_LINK_SENT:
                    return $this->payload([
                        'StatusCode' => '200', 
                        'message' => trans($response), 
                        'result' => new \stdClass
                    ], 200);
                    //return \Response::json(array("status" => 200, "message" => trans($response), "data" => array()));
                case Password::INVALID_USER:
                    return $this->payload([
                        'StatusCode' => '400', 
                        'message' => trans($response), 
                        'result' => new \stdClass
                    ], 200);
                    //return \Response::json(array("status" => 400, "message" => trans($response), "data" => array()));
            }
        } catch (\Swift_TransportException $e) {

            return $this->payload([
                'StatusCode' => '400', 
                'message' => $e->getMessage(), 
                'result' => new \stdClass
            ], 200);

            //$arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
        } catch (Exception $e) {
            return $this->payload([
                'StatusCode' => '400', 
                'message' => $e->getMessage(), 
                'result' => new \stdClass
            ], 200);
            //$arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
        }
        
    }

    public function forgotpin(Request $request){

        try{

            $user = JWTAuth::user();
            $token = Str::random(32);
            $pinreset = PinReset::create(['email' => $user->email, 'token' => $token, 'created_at' => date('Y-m-d H:i:s')]);

            $details = [
                'email' => $pinreset->email,
                'token' => $pinreset->token
            ];

            $response = $user->notify(new ForgotPin($details));
            return $this->payload([
                'StatusCode' => '200', 
                'message' => "We have emailed your pin reset link!", 
                'result' => new \stdClass
            ], 200);


        

        } catch(Exception $e) {
            return $this->payload(['StatusCode' => '422', 'message' => $e->getMessage(), 'result' => new \stdClass], 200);
        }

    }
}
