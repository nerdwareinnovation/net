<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmCategories extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
        'status',
    ];
    
    public function films()
    {
        return $this->hasMany(Films::class, 'category_id');
    }
}

