<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slogan', 'short_description', 'long_description', 'images', 'is_published'];

    protected $casts = [
        'images' => 'array',
    ];

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'category_has_product', 'product_id', 'product_category_id');
    }
  
}