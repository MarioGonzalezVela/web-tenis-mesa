<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class FavoriteVideos extends Model
{
    use HasApiTokens, Notifiable;
    protected $fillable = [
        'customer_id',
        'location_id',
        'review',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
