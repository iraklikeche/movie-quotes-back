<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name.en' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'name.ka' => [
                'required',
                'string',
                'max:255',
                'regex:/^[ა-ჰ\s]+$/'
            ],
            'director.en' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'director.ka' => [
                'required',
                'string',
                'max:255',
                'regex:/^[ა-ჰ\s]+$/'
            ],
            'description.en' => [
                'required',
                'string',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'description.ka' => [
                'required',
                'string',
                'regex:/^[ა-ჰ\s]+$/'
            ],
            'year' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'genres' => 'required|array|min:1',
            'genres.*' => 'required|integer|exists:genres,id',
        ];
    }
}
