<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Wishlist extends Model
{
    use HasFactory;


    public function contents(): BelongsToMany
    {
        return $this->belongsToMany(Content::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }




}
