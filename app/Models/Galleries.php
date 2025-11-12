<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galleries extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'thumbnail',
        'description',
        'child_images',
        'position',
        'status',
    ];
    
    protected $casts = [
        'child_images' => 'array',
    ];
    
    public function category()
    {
        return $this->belongsTo(GalleryCategories::class, 'category_id', 'id');
    }
}

