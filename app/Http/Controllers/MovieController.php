<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\DetailedMovieResource;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MovieController extends Controller
{
    public function store(StoreMovieRequest $request): MovieResource
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


    public function index(): AnonymousResourceCollection
    {
        $movies = Movie::with(['media'])->where('user_id', auth()->id())->get();
        return MovieResource::collection($movies);
    }

    public function show($id): DetailedMovieResource
    {
        $movie = Movie::with(['media', 'genres'])->findOrFail($id);
        return new DetailedMovieResource($movie);
    }

    public function destroy($id): JsonResponse
    {
        $movie = Movie::findOrFail($id);
        if (auth()->id() !== $movie->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $movie->delete();

        return response()->json(['message' => 'Movie deleted successfully']);
    }

    public function update(UpdateMovieRequest $request, $id): DetailedMovieResource
    {
        $movie = Movie::findOrFail($id);

        $validatedData = $request->validated();
        $genres = $validatedData['genres'] ?? null;
        unset($validatedData['genres']);

        $movie->fill($validatedData);

        if ($genres) {
            $movie->genres()->sync($genres);
        }

        if ($request->hasFile('image')) {
            $movie->clearMediaCollection('movies');
            $movie->addMediaFromRequest('image')->toMediaCollection('movies');
        }

        $movie->load('genres', 'media');
        $movie->save();
        return new DetailedMovieResource($movie);
    }



}
