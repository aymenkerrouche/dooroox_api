<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'level_id',
        'specialty',
        'profile_photo_path',
    ];

    /**
     * Get the level associated with the major.
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
