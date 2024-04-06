<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prof extends User
{
    use HasFactory;


    protected $fillable = [
        'Experience',
    ];

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function schools()
    {
        return $this->belongsToMany(School::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function specialties()
    {
        return $this->hasMany(Speciality::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function buys()
    {
         return $this->hasMany(Buy::class);
    }

}
