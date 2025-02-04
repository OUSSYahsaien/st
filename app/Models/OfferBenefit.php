<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferBenefit extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'offer_id',
        'benefit',
    ];
}
