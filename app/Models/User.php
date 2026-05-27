<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'role',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
