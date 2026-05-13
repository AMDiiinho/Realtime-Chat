<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login_view(Request $request){

        return view('login');
    }
    
    public function register_view(){

        return view('register');
    }

    public function auth(Request $request) {

        if (Auth::attempt($request->only('username', 'password'))) {

            return redirect()->intended('home');
        }
    }
    
}
