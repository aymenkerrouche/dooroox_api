<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Level extends Model
{
    use HasFactory;


    protected $fillable = [
        'grade',
        'year',
    ];

    public function specialities(): BelongsToMany
    {
        return $this->belongsToMany(Speciality::class);
    }


}
