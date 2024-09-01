<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'short_des',
        'price',
        'is_discount',
        'discount_price',
        'image',
        'in_stock',
        'stock',
        'star',
        'remark',
        'category_id',
        'brand_id'
    ];
}