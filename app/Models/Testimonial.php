<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'testimonial',
        'client_image',
        'client_name',
        'client_designation',
        'client_company',
        'facebook_link',
        'instagram_link',
        'twitter_link',
        'linkedin_link',
        'video_file',
        'is_published',
    ];
}
