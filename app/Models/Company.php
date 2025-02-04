<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Importez la classe correcte
use Illuminate\Notifications\Notifiable;

class Company extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'secteur_id',
        'name',
        'email',
        'password',
        'tel',
        'is_active',
        'cif',
        'adress',
        'avatar_pic',
        'personel_pic',
        'website',
        'staf_nbr',
        'is_homology',
        'city',
        'poste'
    ];

    /**
     * Les attributs devant être typés.
     */
    protected $casts = [
        'is_active' => 'string',
        'is_homology' => 'string',
        'staf_nbr' => 'integer',
        'date_de_fondation' => 'date'
    ];
}
