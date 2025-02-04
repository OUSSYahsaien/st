<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatSocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_candidat',
        'type',
        'link',
    ];
}
