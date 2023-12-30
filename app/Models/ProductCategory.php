<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = ['category'];

    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_has_product', 'product_category_id', 'product_id');
    }
}
