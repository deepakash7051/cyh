<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('admin.login');
    }

    public function Login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->roles->contains('3') || $user->roles->contains('2') || $user->roles->contains('1')) {
                return redirect()->intended('admin/home');
            } else {
                return redirect('verifycode/'.$user->id);
            }
        }

        return redirect('admin/login')->with('error', 'Opps! You have entered invalid credentials');
    }
}
