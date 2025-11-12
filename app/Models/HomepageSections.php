<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageSections extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'section_name',
        'item_type',
        'item_id',
        'position',
    ];
    
    public function story()
    {
        return $this->belongsTo(\App\Models\Stories::class, 'item_id')->where('item_type', 'story');
    }
    
    public function film()
    {
        return $this->belongsTo(\App\Models\Films::class, 'item_id')->where('item_type', 'film');
    }
    
    public function gallery()
    {
        return $this->belongsTo(\App\Models\Galleries::class, 'item_id')->where('item_type', 'gallery');
    }
}

