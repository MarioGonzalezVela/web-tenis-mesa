<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'image',
        'price',
        'stock',
        'description',
        'category'
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }
}
