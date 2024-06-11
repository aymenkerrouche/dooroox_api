<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Content extends Model
{
    protected $fillable = [
        'creator_id',
        'title',
        'description',
        'cover_picture',
        'total_rate',
        'total_comment',
        'content_type',
        'tag',
        'price'
    ];

    public function prof(): BelongsTo
    {
        return $this->belongsTo(Prof::class);
    }

    public function pdfMaterials(): HasMany
    {
        return $this->hasMany(Pdf_material::class);
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function wishlists(): BelongsToMany
    {
        return $this->belongsToMany(Wishlist::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

}
