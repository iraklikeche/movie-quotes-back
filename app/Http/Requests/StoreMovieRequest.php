<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    public function rules(): array
    {
        return [

            'name.en' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/',

            ],
            'name.ka' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'regex:/^[ა-ჰ\s]+$/'
            ],
            'director.en' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'director.ka' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'regex:/^[ა-ჰ\s]+$/'
            ],
            'description.en' => [
                'sometimes',
                'required',
                'string',
                'regex:/^[a-zA-Z\s,.\-?!]+$/'

            ],
            'description.ka' => [
                'sometimes',
                'required',
                'string',
                'regex:/^[ა-ჰ\s,.\-?!]+$/'
            ],
            'year' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
        ];
    }
}
