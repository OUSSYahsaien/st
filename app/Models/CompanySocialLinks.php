<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySocialLinks extends Model
{
    use HasFactory;

    protected $table = 'company_social_links';

    protected $fillable = [
        'company_id',
        'type',
        'value',
    ];

}
