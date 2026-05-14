<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home_view(){

        $rooms = auth()->user()->rooms()->latest()->get();

        return view('home', compact('rooms'));
    }
}
