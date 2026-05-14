<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    public function create (Request $request) {

        $room = Room::create ([

            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'type' => $request->type,
            'password' => $request->password,
            'owner_id' => auth()->id()
        ]);

        return $room;
    }
}
