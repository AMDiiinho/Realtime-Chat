<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'body',
    ];

    protected function casts(): array
    {
        return [
            'body' => 'string'
        ];
    }
}
