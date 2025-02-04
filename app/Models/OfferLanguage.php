<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferLanguage extends Model
{
    use HasFactory;

    // Définir la table si elle diffère de la convention
    protected $table = 'offer_languages';

    // Définir les champs qui peuvent être assignés en masse
    protected $fillable = [
        'offer_id',
        'language',
    ];
}
