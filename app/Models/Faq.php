<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'answer', 'category_id', 'is_published'];


    public function category()
    {
        return $this->belongsTo(FaqCategory::class);
    }
}
