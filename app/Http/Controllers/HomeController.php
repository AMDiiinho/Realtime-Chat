<?php

namespace App\Http\Controllers;

use App\Models\Room;

class HomeController extends Controller
{
    public function home_view()
    {
        $publicRooms = Room::where('type', 'public')->latest()->get();

        $myRooms = auth()->user()
            ->rooms()
            ->latest()
            ->get();

        return view('home', compact('publicRooms', 'myRooms'));
    }
}
