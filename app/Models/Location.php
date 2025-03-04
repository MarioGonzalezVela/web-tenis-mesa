<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Location extends Model
{
    use HasApiTokens, Notifiable;
    protected $fillable = [
        'name',
        'phone',
        'address',
        'schedule',
    ];

    public function visitors()
    {
        return $this->belongsToMany(Customer::class, 'visited_locations')
            ->withTimestamps();
    }
}
