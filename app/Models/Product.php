<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slogan', 'category_id', 'short_description', 'long_description', 'images', 'is_published'];


    protected $casts = [
        'images' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
