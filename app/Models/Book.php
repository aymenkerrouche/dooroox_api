<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'description',
        'price',
        'path',
        'prof_id', 
       
    ];


    public function prof()
    {
        return $this->belongsTo(Prof::class);
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }
}
