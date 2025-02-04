<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferNiceToHave extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id',
        'nice_to_have',
    ];

}
