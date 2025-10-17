<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'new_users'; // optional, good to be explicit

    // Allow mass assignment for these fields
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'role', // optional
    ];

    // Hide password when returning model
    protected $hidden = [
        'password',
    ];
}
