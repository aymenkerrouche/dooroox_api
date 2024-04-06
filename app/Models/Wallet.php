<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'rib',
        'amount',
        'source',
    ];

    public function prof()
    {
        return $this->hasOne(Prof::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function student()
    {
        return $this->hasOne(Prof::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
    
}
