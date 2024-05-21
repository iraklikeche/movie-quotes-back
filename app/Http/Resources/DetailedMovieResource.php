<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedMovieResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $movieNameEn = $this->getTranslation('name', 'en');
        $movieNameKa = $this->getTranslation('name', 'ka');
        $directorEn = $this->getTranslation('director', 'en');
        $directorKa = $this->getTranslation('director', 'ka');
        $descriptionEn = $this->getTranslation('description', 'en');
        $descriptionKa = $this->getTranslation('description', 'ka');
        $imageUrl = $this->media->first()?->getUrl() ?? null;

        return [
            'id' => $this->id,
            'movie_name' => [
                'en' => $movieNameEn,
                'ka' => $movieNameKa,
            ],
            'year' => $this->year,
            'image_url' => $imageUrl,
            'director' => [
                'en' => $directorEn,
                'ka' => $directorKa,
            ],
            'description' => [
                'en' => $descriptionEn,
                'ka' => $descriptionKa,
            ],
            'genres' => GenreResource::collection($this->genres),
        ];
    }
}
