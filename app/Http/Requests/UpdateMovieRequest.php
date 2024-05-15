<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name.en' => 'sometimes|required|string|max:255',
            'name.ka' => 'sometimes|required|string|max:255',
            'director.en' => 'sometimes|required|string|max:255',
            'director.ka' => 'sometimes|required|string|max:255',
            'description.en' => 'sometimes|required|string',
            'description.ka' => 'sometimes|required|string',
            'year' => 'sometimes|required|integer',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'genres' => 'sometimes|required|array',
            'genres.*' => 'exists:genres,id',
        ];
    }
}
