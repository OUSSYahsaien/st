<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatSkills extends Model
{
    use HasFactory;

    protected $table = 'candidat_skills'; // Spécifiez le nom de la table si nécessaire

    // Définir les colonnes qui peuvent être assignées en masse
    protected $fillable = [
        'id_candidat',
        'description',
    ];
}
