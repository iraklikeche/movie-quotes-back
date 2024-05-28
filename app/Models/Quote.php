<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Quote extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = ['content', 'user_id', 'movie_id'];
    protected $appends = ['image_url','likes_count', 'liked_by_user', 'comments_count'];


    public $translatable = ['content'];

    protected $casts = [
        'content' => 'array',
        'user_id' => 'integer',
        'movie_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function getLikedByUserAttribute()
    {
        return $this->likes->contains('user_id', auth()->id());
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }


    public function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('images');
    }

    public function scopeFilterContentEn(Builder $query, $content)
    {
        return $query->where('content->en', 'LIKE', "%{$content}%");
    }

    public function scopeFilterContentKa(Builder $query, $content)
    {
        return $query->where('content->ka', 'LIKE', "%{$content}%");
    }

    public function scopeFilterMovieNameEn(Builder $query, $name)
    {
        return $query->whereHas('movie', function ($query) use ($name) {
            $query->where('name->en', 'LIKE', "%{$name}%");
        });
    }

    public function scopeFilterMovieNameKa(Builder $query, $name)
    {
        return $query->whereHas('movie', function ($query) use ($name) {
            $query->where('name->ka', 'LIKE', "%{$name}%");
        });
    }



}
