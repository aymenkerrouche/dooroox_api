<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quizz extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description'
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

}
