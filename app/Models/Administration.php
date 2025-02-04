<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Administration extends Authenticatable
{
    use Notifiable;
    
    protected $fillable = [
        'username',
        'email',
        'password',
        'image_name',
    ];


    protected $hidden = [
        'password',
    ];
}
