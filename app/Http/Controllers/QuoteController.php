<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Models\Quote;

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

        return response()->json([
            'message' => 'Quote created successfully!',
            'quote' => $quote->toArray() + ['image_url' => $quote->image_url]
        ], 201);
    }

    public function show($id)
    {
        $quote = Quote::with(['user', 'movie', 'comments', 'likes'])->findOrFail($id);
        return response()->json($quote);
    }

    public function index()
    {
        $quotes = Quote::with(['user', 'movie'])->latest()->get();
        return response()->json($quotes);
    }
}
