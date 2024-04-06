<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pdf_material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
