<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Hash;
use App\Libraries\OnewaySms;
use App\SmsVerification;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /*public function redirectTo() {
        $user = auth()->user(); 
        if ($user->roles->contains('3') || $user->roles->contains('2') || $user->roles->contains('1')) {
            return redirect('/admin/login');
        } else {
            return redirect('/login');
        }
    }*/

    public function logout(Request $request)
    {

        $user = auth()->user();
        if ($user->roles->contains('3') || $user->roles->contains('2') || $user->roles->contains('1')) {
            $request->session()->flush();
            $request->session()->regenerate();
            return redirect('/admin');
        } else {
            $request->session()->flush();
            $request->session()->regenerate();
            return redirect('/login');
        }

    }

    public function sendcode(Request $request)
    {

        $email = $request->email;
        $password = $request->password;

        $query = User::where('email', $email);

        if($query->count() > 0){
            $user = $query->first();
            if (Hash::check($password, $user->password))
            {
                $code = rand(1000, 9999);
                $debug = false;
                $mobile = $user->isd_code.$user->phone;
                $smsverify = SmsVerification::create([
                    'code' => $code, 
                    'phone' => $mobile, 
                    'status' => 'pending'
                ]);

                $message = trans('global.code_message').' '.$code;

                //$result = OnewaySms::send($mobile, $message, $debug);

                //if($result['status']){
                if($smsverify){
                    return redirect()->route('verifycode', $user->id);
                } else {
                    return redirect()->back()->with('error', trans('validation.password'));
                }
            } else {
                return redirect()->back()->with('error', trans('validation.password'));
            }
        } else {
            return redirect()->back()->with('error', trans('passwords.user'));
        }

    }

    public function verifycode($id){
        $user = User::find($id);

        $phone = $user->isd_code.$user->phone;
        $message = SmsVerification::where('phone', $phone)->orderBy('id', 'desc')->first();
        return view('auth.verifycode', compact('user', 'message'));
    }

    public function verifyusercode(Request $request){
        $phone = $request->isd_code.$request->phone;
        $code = $request->code;
        $user_id = $request->user_id;

        $message = SmsVerification::where('phone', $phone)->orderBy('id', 'desc')->first();
        if($message->code==$code && $message->status=='pending'){
            $message->update(['status' => 'verify']);
            $user = User::find($user_id);
            Auth::login($user);
            return redirect('/home');
        } else {
            return back()->withErrors(['code' => [trans('global.pages.frontend.verifycode.invalid_code')]]);
        }
    }

}
