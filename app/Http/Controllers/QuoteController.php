<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Str;

class QuoteController extends Controller
{
    public function store(StoreQuoteRequest $request)
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
        $quote->user->append('profile_image_url');

        return response()->json([
            'message' => 'Quote created successfully!',
            'quote' => $quote
        ], 201);
    }

    public function show($id)
    {
        $quote = Quote::with(['user', 'movie', 'comments', 'likes'])->findOrFail($id);
        return response()->json($quote);
    }

    public function index(Request $request)
    {
        $userId = Auth::id();
        $searchQuery = $request->input('search', '');

        $quotesQuery = QueryBuilder::for(Quote::class)
            ->allowedIncludes(['user', 'movie', 'comments', 'likes'])
            ->allowedFilters([
                AllowedFilter::scope('content_en', 'filterContentEn'),
                AllowedFilter::scope('content_ka', 'filterContentKa'),
                AllowedFilter::scope('movie_name_en', 'filterMovieNameEn'),
                AllowedFilter::scope('movie_name_ka', 'filterMovieNameKa')
            ])
            ->with(['user', 'movie', 'comments', 'likes'])
            ->latest();

        if (!empty($searchQuery)) {
            if (str_starts_with($searchQuery, '#')) {
                $searchTerm = substr($searchQuery, 1);
                $quotesQuery->where(function ($query) use ($searchTerm) {
                    $query->where('content->en', 'LIKE', "%{$searchTerm}%")
                          ->orWhere('content->ka', 'LIKE', "%{$searchTerm}%");
                });
            } elseif (str_starts_with($searchQuery, '@')) {
                $searchTerm = substr($searchQuery, 1);
                $quotesQuery->whereHas('movie', function ($query) use ($searchTerm) {
                    $query->where('name->en', 'LIKE', "%{$searchTerm}%")
                          ->orWhere('name->ka', 'LIKE', "%{$searchTerm}%");
                });
            }
        }

        $quotes = $quotesQuery->get();

        $quotes->each(function ($quote) use ($userId) {
            $quote->append('image_url');
            $quote->liked_by_user = $quote->likes->contains('user_id', $userId);
            $quote->like_count = $quote->likes->count();
            $quote->user->append('profile_image_url');
        });

        return response()->json($quotes);
    }



}
