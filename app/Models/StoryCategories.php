<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryCategories extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail',
        'position',
        'status',
    ];
    
    public function stories(){
        return $this->hasMany(Stories::class, 'category_id');
    }
}

