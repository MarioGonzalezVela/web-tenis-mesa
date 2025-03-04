<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Customer extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $fillable = [
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
        return $this->hasMany(FavoriteVideos::class, 'customer_id');
    }

    public function visitedLocations()
    {
        return $this->belongsToMany(Location::class, 'visited_locations')
            ->withTimestamps();
    }
}
