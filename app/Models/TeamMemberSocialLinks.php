<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMemberSocialLinks extends Model
{
    use HasFactory;

    protected $table = 'team_member_social_links';

    protected $fillable = [
        'member_id',
        'type',
        'value',
    ];
}
