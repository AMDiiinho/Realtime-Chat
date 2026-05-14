<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(Request $request){

        return view('login');
    }
    
    public function register_index(){

        return view('register');
    }

    public function auth(Request $request) {

        if (Auth::attempt($request->only('username', 'password'))) {

            return redirect()->intended('home');
        }
    }
    
}
