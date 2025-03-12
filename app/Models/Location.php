<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
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
