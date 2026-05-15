<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RoomController extends Controller
{

    public function index(Room $room) {

        $isMember = $room->myUsers()->where('users.id', auth()->id())->exists();

        if ($room->type === 'private' && !$isMember) {

            abort(403, 'Você não tem acesso à essa sala');
        }

        if ($room->type === 'public' && !$isMember) {

            $room->users()->attach(auth()->id());
        }

        $messages = $room->messages()
            ->with('user')
            ->latest()
            ->take(50)
            ->get()
            ->reverse();

        return view('room', compact('room', 'messages'));
    }   


    public function store (Request $request) {

        $room = Room::create ([

            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'type' => $request->type,
            'password' => $request->type === 'private' ? : null,
            'owner_id' => auth()->id()
        ]);

        $room->myUsers()->attach(auth()->id());

        return redirect()->route('room.index', $room);
    }

    public function delete(Int $room_id) {

        $room = Room::find($room_id);

        if (!$room) { 
            
            return redirect()->back()->with('error', 'Room not found');
        }

        $room->delete();

        return redirect()->back();
    }

    public function join(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'nullable|string',
        ]);

        $room = Room::where('name', $request->name)->first();

        if (! $room) {
            return back()->withErrors([
                'name' => 'Sala não encontrada.',
            ]);
        }

        if ($room->type === 'private') {
            if (! $request->filled('password')) {
                return back()->withErrors([
                    'password' => 'Essa sala é privada. Informe a senha.',
                ]);
            }

            if (! $request->password == $room->password) {
                return back()->withErrors([
                    'password' => 'Senha incorreta.',
                ]);
            }
        }

        $room->myUsers()->syncWithoutDetaching([
            auth()->id() => [
                'joined_at' => now(),
                'last_read_at' => now(),
            ],
        ]);

        return redirect()->route('room.index', $room);
    }
}
