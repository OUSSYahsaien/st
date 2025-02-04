<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferResponsibilities extends Model
{
    use HasFactory;

    // Les colonnes modifiables
    protected $fillable = ['offer_id', 'responsibility'];
}
