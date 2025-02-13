<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class QuoteController extends Controller
{
    public function store(StoreQuoteRequest $request): JsonResponse
    {

        $quote = Quote::create([
            'content' => $request->input('content'),
            'user_id' => auth()->id(),
            'movie_id' => $request->input('movie_id'),
        ]);

        if ($request->hasFile('image')) {
            $quote->addMedia($request->file('image'))->toMediaCollection('images');
        }

        $quote->load('user', 'movie');

        return response()->json([
            'message' => 'Quote created successfully!',
            'quote' => $quote
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $quote = Quote::with(['user', 'movie'])->findOrFail($id);
        return response()->json($quote);
    }
    public function index(Request $request): JsonResponse
    {
        $userId = Auth::id();
        $searchQuery = $request->input('search', '');
        $perPage = $request->input('per_page', 10);


        $quotesQuery = QueryBuilder::for(Quote::class)
            ->allowedIncludes(['user', 'movie', 'comments', 'likes'])
            ->allowedFilters([
                AllowedFilter::scope('content_en', 'filterContentEn'),
                AllowedFilter::scope('content_ka', 'filterContentKa'),
                AllowedFilter::scope('movie_name_en', 'filterMovieNameEn'),
                AllowedFilter::scope('movie_name_ka', 'filterMovieNameKa')
            ])
            ->with(['user', 'movie', 'comments', 'likes'])
            ->withCount(['likes','comments'])
            ->latest();

        if (!empty($searchQuery)) {
            if (str_starts_with($searchQuery, '#')) {
                $searchTerm = substr($searchQuery, 1);
                $quotesQuery->where(function ($query) use ($searchTerm) {
                    $query->whereRaw('LOWER(json_extract(content, "$.en")) LIKE ?', ["%".strtolower($searchTerm)."%"])
                          ->orWhereRaw('LOWER(json_extract(content, "$.ka")) LIKE ?', ["%".strtolower($searchTerm)."%"]);
                });
            } elseif (str_starts_with($searchQuery, '@')) {
                $searchTerm = substr($searchQuery, 1);
                $quotesQuery->whereHas('movie', function ($query) use ($searchTerm) {
                    $query->whereRaw('LOWER(json_extract(name, "$.en")) LIKE ?', ["%".strtolower($searchTerm)."%"])
                          ->orWhereRaw('LOWER(json_extract(name, "$.ka")) LIKE ?', ["%".strtolower($searchTerm)."%"]);
                });
            }
        }


        $quotes = $quotesQuery->paginate($perPage);

        $quotes->each(function ($quote) use ($userId) {
            $quote->append('image_url');
            $quote->liked_by_user = $quote->likes->contains('user_id', $userId);
        });

        return response()->json($quotes);
    }


    public function quotesByMovie($movieId): JsonResponse
    {
        $userId = Auth::id();
        $quotes = Quote::where('movie_id', $movieId)
            ->with(['user', 'comments', 'likes'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->get();

        $quotes->each(function ($quote) use ($userId) {
            $quote->liked_by_user = $quote->likes->contains('user_id', $userId);

        });

        return response()->json($quotes);
    }

    public function destroy($id): JsonResponse
    {
        $quote = Quote::findOrFail($id);

        if ($quote->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $quote->delete();

        return response()->json(['message' => 'Quote deleted successfully!']);
    }

    public function update(UpdateQuoteRequest $request, $id): JsonResponse
    {
        $quote = Quote::findOrFail($id);

        if ($quote->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $existingContent = json_decode($quote->content, true) ?? [];

        $content = array_merge($existingContent, $request->input('content', []));

        $data = $request->only(['movie_id']);
        $data['content'] = $content;

        $quote->update($data);

        if ($request->hasFile('image')) {
            $quote->clearMediaCollection('images');
            $quote->addMedia($request->file('image'))->toMediaCollection('images');
        }

        $quote->load('user', 'movie');
        $quote->user->append('profile_image_url');

        return response()->json(['message' => 'Quote updated successfully!', 'quote' => $quote]);
    }


}
