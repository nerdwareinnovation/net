<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'short_description',
        'image',
        'position',
        'status',
        'button_text',
        'button_url',
    ];
}

