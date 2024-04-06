<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'title',
        'description',
        'cover_picture',
        'total_rate',
        'total_comment',
        'content_type',
        'tag',
        'price'
    ];

    public function prof()
    {
        return $this->belongsTo(Prof::class);
    }

    public function pdf_material()
    {
        return $this->hasMany(Pdf_material::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function wishlistes()
    {
        return $this->belongsToMany(Wishlist::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

}
