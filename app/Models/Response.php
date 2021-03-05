<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'answer'
    ];
    public $timestamps = false;

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
