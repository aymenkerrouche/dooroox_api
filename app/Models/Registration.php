<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'content_id',
        'amount'
    ];



    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }

}
