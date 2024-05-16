<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Models\Quote;
use Illuminate\Support\Facades\Auth;

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

    public function index()
    {
        $quotes = Quote::with(['user', 'movie','comments', 'likes'])->latest()->get();
        $userId = Auth::id();

        $quotes->each(function ($quote) use ($userId) {
            $quote->append('image_url');
            $quote->liked_by_user = $quote->likes->contains('user_id', $userId);
            $quote->like_count = $quote->likes->count();
            $quote->user->append('profile_image_url');
        });

        return response()->json($quotes);
    }
}
