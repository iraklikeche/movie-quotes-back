<?php

namespace App\Http\Controllers;

use App\Http\Resources\GenreResource;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        // $language = $request->cookie('locale', 'ka');
        // // $genres = Genre::all();
        // // return response()->json($genres);
        // $genres = Genre::all()->map(function ($genre) use ($language) {
        //     $genre->name = $language == 'ka' ? $genre->name_ka : $genre->name_en;
        //     return $genre;
        // });

        // return response()->json($genres);
        $genres = Genre::all();

        // Use the resource to format the output
        return GenreResource::collection($genres);

    }
}
