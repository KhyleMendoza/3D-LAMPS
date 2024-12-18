<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class promo extends Model
{
    protected $fillable = [
        'code',
        'quantity',
        'discount_percentage',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'discount_percentage' => 'integer',
    ];
}
