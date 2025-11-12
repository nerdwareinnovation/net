<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stories extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'category_id',
        'user_id',
        'slug',
        'thumbnail',
        'description',
        'story_images',
        'is_featured',
        'position',
        'status',
    ];
    
    protected $casts = [
        'story_images' => 'array',
        'is_featured' => 'boolean',
    ];
    
    public function category()
    {
        return $this->belongsTo(StoryCategories::class, 'category_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

