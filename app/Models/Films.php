<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Films extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'film_poster',
        'film_banner',
        'release_date',
        'watch_time',
        'trailer_link',
        'synopsis',
        'genre',
        'tags',
        'description',
        'watch_link',
        'film_images',
        'position',
        'status',
    ];
    
    protected $casts = [
        'genre' => 'array',
        'tags' => 'array',
        'film_images' => 'array',
        'release_date' => 'date',
    ];
    
    public function category()
    {
        return $this->belongsTo(FilmCategories::class, 'category_id', 'id');
    }
}

