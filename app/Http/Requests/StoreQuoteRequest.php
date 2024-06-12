<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content.en' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\s,.!\-?\'"]+$/'

            ],
            'content.ka' => [
                'required',
                'string',
                'regex:/^[ა-ჰ0-9\s,.!\-?\'"]+$/'

            ],
            'movie_id' => 'required|exists:movies,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
