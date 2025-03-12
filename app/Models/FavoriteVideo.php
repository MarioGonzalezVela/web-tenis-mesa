<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteVideo extends Model
{
    protected $fillable = [
        'customer_id',
        'video_id',
        'saved_date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }
}
