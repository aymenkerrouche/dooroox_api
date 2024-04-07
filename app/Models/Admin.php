<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Admin extends User
{
    use HasFactory;

    protected $fillable = [
        'role'
    ];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'profile');
    }

    public function manageUsers()
    {
        // Logic for managing users
    }

    public function manageFinancialTransactions()
    {
        // Logic for managing financial transactions
    }


}
