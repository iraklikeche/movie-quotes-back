<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content.en' => 'required|string',
            'content.ka' => 'required|string',
            'movie_id' => 'required|exists:movies,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
