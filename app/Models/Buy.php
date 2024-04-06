<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;

    protected $fillable = [
        'ref',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
