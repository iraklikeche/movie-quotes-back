<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'movie_en' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'movie_ka' => ['required', 'string', 'max:255', 'regex:/^[\p{Georgian}\s]+$/u'],
            'year' => 'required|integer',
            'director_en' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'director_ka' => ['required', 'string', 'max:255', 'regex:/^[\p{Georgian}\s]+$/u'],
            'description_en' => ['required', 'string', 'regex:/^[A-Za-z\s]+$/'],
            'description_ka' => ['required', 'string', 'regex:/^[\p{Georgian}\s]+$/u'],
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
        ];
    }
}
