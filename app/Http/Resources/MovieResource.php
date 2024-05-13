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

        // $imageUrl = $this->media->first()?->getUrl() ?? null;

        // return [
        //     'movie_en' => $this->movie_en,
        //     'movie_ka' => $this->movie_ka,
        //     'year' => $this->year,
        //     'image_url' => $imageUrl,
        // ];
        $locale = $request->header('Accept-Language', 'en');
        $movieName = $locale === 'ka' ? $this->movie_ka : $this->movie_en;

        $imageUrl = $this->media->first()?->getUrl() ?? null;

        return [
            'id' => $this->id,
            'movie_name' => $movieName,
            'year' => $this->year,
          
            'image_url' => $imageUrl,
        ];
    }
}
