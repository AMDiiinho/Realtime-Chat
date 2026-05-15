<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    public function store (Request $request) {

        $room = Room::create ([

            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'type' => $request->type,
            'password' => $request->password,
            'owner_id' => auth()->id()
        ]);

        return redirect()->back();
    }

    public function delete(Int $room_id) {

        $room = Room::find($room_id);

        if (!$room) { 
            
            return redirect()->back()->with('error', 'Room not found');
        }

        $room->delete();

        return redirect()->back();
    }
}
