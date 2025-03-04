<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use HasApiTokens, Notifiable;
    protected $fillable = [
        'name',
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
