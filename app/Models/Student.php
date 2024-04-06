<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends User
{
    use HasFactory;


    protected $fillable = [
        'level',
        'wilaya',
        'district',
        'birthday'
    ];

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function wishlist()
    {
        return $this->hasOne(Wishlist::class);
    }

    public function schools()
    {
        return $this->belongsToMany(School::class);
    }

}
