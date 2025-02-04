<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigEquipeMember extends Model
{
    use HasFactory;

    // Nom de la table si différent du pluriel du modèle
    protected $table = 'config_equipe_members';

    // Champs modifiables
    protected $fillable = [
        'team_member_id',
        'additional_info',
        'location',
        'specific_location',
    ];
}
