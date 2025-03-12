<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'title',
        'link',
        'description',
        'difficulty',
    ];

    public function favoriteVideos()
    {
        return $this->hasMany(FavoriteVideos::class, 'video_id');
    }
}
