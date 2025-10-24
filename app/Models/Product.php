<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class product extends Model
{
    use HasFactory ;
    protected $fillable = [
        'title',
        'meta_title',
        'meta_keywords',
        'slug',
        'short_description',
        'key_benefits',
        'description',
        'ingredient',
        'price',
         'mrp_price',
    'discount',
        'best_product',
    ];  
    public function images()
{
    return $this->hasMany(ProductImage::class);
}

}
