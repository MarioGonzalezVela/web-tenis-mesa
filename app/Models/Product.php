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

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
