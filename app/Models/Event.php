<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start',
        'end',
        'id_candidat',
        'id_company'
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime'
    ];

}
