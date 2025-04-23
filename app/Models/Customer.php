<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'remember_token'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed'
        ];
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'customer_id');
    }

    public function favoriteVideos()
    {
        return $this->hasMany(FavoriteVideo::class, 'customer_id');
    }

    public function visitedLocations()
    {
        return $this->belongsToMany(Location::class, 'visited_locations')
            ->withTimestamps();
    }
}
