<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedMovieResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->header('Accept-Language', 'en');
        $movieName = $locale === 'ka' ? $this->movie_ka : $this->movie_en;
        $director = $locale === 'ka' ? $this->director_ka : $this->director_en;
        $description = $locale === 'ka' ? $this->description_ka : $this->description_en;
        $imageUrl = $this->media->first()?->getUrl() ?? null;

        return [
            'id' => $this->id,
            'movie_name' => $movieName,
            'year' => $this->year,
            'image_url' => $imageUrl,
            'director' => $director,
            'description' => $description,
            'genres' => GenreResource::collection($this->genres),
        ];
    }
}
