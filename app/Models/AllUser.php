<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AllUser extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'is_verified'];
}