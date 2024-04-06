<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;


    protected $fillable = [
        'grade',
        'year',
    ];

    public function specialities()
    {
        return $this->hasMany(Speciality::class);
    }


}
