<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedMovieResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->header('Accept-Language', 'en');
        $movieName = $this->getTranslation('name', $locale);
        $director = $this->getTranslation('director', $locale);
        $description = $this->getTranslation('description', $locale);
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
