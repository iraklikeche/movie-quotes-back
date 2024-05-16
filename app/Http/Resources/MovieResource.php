<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $locale = $request->header('Accept-Language', 'en');

        $movieName = $this->resource->getTranslation('name', $locale);

        $imageUrl = $this->media->first()?->getUrl() ?? null;

        return [
            'id' => $this->id,
            'movie_name' => $movieName,
            'year' => $this->year,
            'image_url' => $imageUrl,
        ];
    }
}
