<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Candidat extends Authenticatable
{
    use HasFactory;
    use Notifiable;


    /**
     * Les attributs qui sont attribuables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'secteur_id',
        'langue_id',
        'first_name',
        'last_name',
        'email',
        'tel',
        'password',
        'date_of_birth',
        'adresse',
        'gender',
        'is_active',
        'cv_file_path',
        'priority',
        'avatar_path',
        'personal_picture_path',
        'poste',
    ];

    /**
     * Masquer certains attributs dans les réponses JSON.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

}
