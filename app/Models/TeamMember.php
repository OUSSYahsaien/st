<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'full_name',
        'poste',
        'location',
        'email',
        'tel_1',
        'tel_2',
        'personel_pic',
        'avatar_pic',
        'role',
    ];
}
