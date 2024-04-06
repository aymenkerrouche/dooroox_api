<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'content_id',
        'amount'
    ];



    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

}
