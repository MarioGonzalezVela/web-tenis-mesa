<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Video extends Model
{
    use HasApiTokens, Notifiable;
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
