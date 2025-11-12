<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageSettings extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'vimeo_video_id',
        'vimeo_title',
        'vimeo_description',
        'vimeo_button_text',
        'vimeo_button_url',
        'vimeo_film_ids',
        'featured_story_banner_image',
        'featured_story_title',
        'featured_story_description',
        'featured_story_button_text',
        'featured_story_button_url',
    ];
    
    protected $casts = [
        'vimeo_film_ids' => 'array',
    ];
}

