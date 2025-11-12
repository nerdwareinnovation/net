<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSettings extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'banner_image',
        'title',
        'short_description',
    ];
}

