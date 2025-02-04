<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_offer',
        'id_candidat',
        'status',
        'motivation_letter',
        'cv_name',
    ];
}
