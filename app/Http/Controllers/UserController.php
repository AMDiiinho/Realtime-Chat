<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create(Request $request) {

        
        $user = User::create([

            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password
        ]);

        Auth::login($user);

        return redirect()->intended('home');
    }
}
