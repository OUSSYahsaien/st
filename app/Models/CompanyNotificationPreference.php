<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyNotificationPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'first',
        'second',
        'third',
    ];
}
