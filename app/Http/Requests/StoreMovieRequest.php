<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    public function rules(): array
    {
        return [

            'name.en' => ['required', 'string', 'max:255'],
            'name.ka' => ['required', 'string', 'max:255'],
            'director.en' => ['required', 'string', 'max:255'],
            'director.ka' => ['required', 'string', 'max:255'],
            'description.en' => ['required', 'string'],
            'description.ka' => ['required', 'string'],
            'year' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
        ];
    }
}
