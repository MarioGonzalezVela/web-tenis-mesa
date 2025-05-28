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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class)->cascadeOnDelete();
    }

    public function favoriteVideos()
    {
        return $this->hasMany(FavoriteVideo::class)->cascadeOnDelete();
    }

    public function visitedLocations()
    {
        return $this->hasMany(VisitedLocation::class)->cascadeOnDelete();
    }
}
