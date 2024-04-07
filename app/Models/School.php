<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'Address',
        'location',
        'latitude',
        'longitude'
    ];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'profile');
    }

    public function profs(): HasMany
    {
        return $this->hasMany(Prof::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
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
