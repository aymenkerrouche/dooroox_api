<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Prof extends User
{
    use HasFactory;


    protected $fillable = [
        'phone',
        'location',
        'latitude',
        'longitude'
    ];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'profile');
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }

    public function schools(): BelongsToMany
    {
        return $this->belongsToMany(School::class);
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

}
