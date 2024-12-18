<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'discounted_price',
        'discount',
        'description',
        'image',
        'category',
        'sold',
        'stock',
        'colors',
        'size',
        'ratings',
        'reviews',
    ];
}
