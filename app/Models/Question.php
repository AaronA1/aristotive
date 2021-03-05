<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'type',
        'question',
        'options',
        'image'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

}
