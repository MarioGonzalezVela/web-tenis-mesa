<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitedLocation extends Model
{
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
