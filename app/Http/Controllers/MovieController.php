<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Resources\DetailedMovieResource;
use App\Http\Resources\MovieResource;
use App\Models\Movie;

class MovieController extends Controller
{
    public function store(StoreMovieRequest $request)
    {


        $movie = new Movie($request->validated());
        $movie->user_id = auth()->id();
        $movie->save();

        $movie->genres()->sync($request->genres);
        $movie->load('genres');
        $movie->append('media_urls');


        if ($request->hasFile('image')) {
            $movie->addMediaFromRequest('image')->toMediaCollection('movies');
        }

        return new MovieResource($movie);

    }


    public function index()
    {
        $movies = Movie::with(['media'])->get();
        return MovieResource::collection($movies);
    }

    public function show($id)
    {
        $movie = Movie::with(['media', 'genres'])->findOrFail($id);
        return new DetailedMovieResource($movie);
    }
}
