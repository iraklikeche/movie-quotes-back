<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedMovieResource extends JsonResource
{
    public function toArray(Request $request): array
    {
    
        $nameTranslations = $this->getTranslations('name');
        $directorTranslations = $this->getTranslations('director');
        $descriptionTranslations = $this->getTranslations('description');
        $imageUrl = $this->media->first()?->getUrl() ?? null;

        return [
            'id' => $this->id,
            'movie_name' => $nameTranslations,
            'year' => $this->year,
            'image_url' => $imageUrl,
            'director' => $directorTranslations,
            'description' => $descriptionTranslations,
            'genres' => GenreResource::collection($this->genres),
        ];
    }
}
