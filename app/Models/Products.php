<?php

namespace App\Models;

use Givebutter\LaravelCustomFields\Traits\HasCustomFieldResponses;
use Givebutter\LaravelCustomFields\Traits\HasCustomFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory, HasCustomFields, HasCustomFieldResponses;
    public function category(){
        return $this->belongsTo(ProductCategories::class, 'category_id');
    }
    protected $casts = [
        'images' => 'array',
    ];
}
