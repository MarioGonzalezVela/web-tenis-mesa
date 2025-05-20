<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relación corregida con User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
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
