<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        // tenta logar com sessão
        if (! Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return back()->withErrors(['message' => 'Credenciais inválidas']);
        }

        $request->session()->regenerate(); // segurança contra session fixation

        return redirect()->intended('/home');
    }
    
}
