<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $table = 'experiences';

    protected $fillable = [
        'id_candidat',
        'company_name',
        'post',
        'location',
        'begin_date',
        'end_date',
        'work_type',
        'description',
    ];
}
