<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rib',
        'balance',
        'status',
    ];

    public function prof(): HasOne
    {
        return $this->hasOne(Prof::class);
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function school(): HasOne
    {
        return $this->hasOne(School::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

}
