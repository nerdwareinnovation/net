<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryCategories extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
        'status',
    ];
    
    public function galleries()
    {
        return $this->hasMany(Galleries::class, 'category_id');
    }
}

