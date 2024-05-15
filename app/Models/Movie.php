<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Movie extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasTranslations;

    public $translatable = ['name', 'director', 'description'];

    protected $guarded = ['id'];
    protected $casts = [
        'name' => 'array',
        'director' => 'array',
        'description' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function getMediaUrlsAttribute()
    {
        return $this->getMedia('movies')->map(function (Media $media) {
            return $media->getUrl();
        });
    }

}
