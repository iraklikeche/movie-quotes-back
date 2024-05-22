<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Quote;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, $quoteId)
    {

        $comment = Comment::create([
            'content' => $request->input('content'),
            'user_id' => auth()->id(),
            'quote_id' => $quoteId,
        ]);

        $comment->load('user');
        return response()->json(['message' => 'Comment added successfully!', 'comment' => $comment], 201);
    }


    public function index($quoteId)
    {
        $quote = Quote::findOrFail($quoteId);
        $comments = $quote->comments()->with('user')->latest()->get();
        return response()->json($comments);
    }
}
