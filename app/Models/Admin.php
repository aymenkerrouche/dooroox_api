<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends User
{
    use HasFactory;

    protected $fillable = [
        'role',

    ];

    public function manageUsers()
    {
        // Logic for managing users
    }

    public function manageFinancialTransactions()
    {
        // Logic for managing financial transactions
    }


}
