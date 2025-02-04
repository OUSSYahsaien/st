<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'title',
        'id_company',
        'nbr_candidat_max',
        'nbr_candidat_confermed',
        'place',
        'work_type',
        'starting_salary',
        'final_salary',
        'category',
        'experience_years',
        'priority',
        'postulation_deadline ',
    ];

    protected $casts = [
        'postulation_deadline' => 'datetime',
        'publication_date' => 'datetime',
    ];
    

}
