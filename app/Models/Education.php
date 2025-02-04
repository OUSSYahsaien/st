<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_name',
        'id_candidat',
        'subject',
        'begin_date',
        'end_date',
        'description',
        'education_logo_path',
    ];
}
