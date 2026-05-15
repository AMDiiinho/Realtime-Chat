<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{

    public function myUsers(){
        return $this->belongsToMany(User::class, 'room_user', 'room_id', 'user_id')
            ->withPivot(['joined_at', 'last_read_at'])
            ->withTimestamps();
    }

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function messages() {
        
        return $this->hasMany(Message::class);
    }

    protected $fillable = [
        'name',
        'slug',
        'type',
        'password',
        'owner_id'
    ];

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'slug' => 'string',
            'type' => 'string'
        ];
    }
}
