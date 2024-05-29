<?php

namespace App\Http\Controllers;

use App\Events\QuoteCommented;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Quote;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, $quoteId)
    {

        $user = auth()->user();
        $quote = Quote::with(['user', 'comments', 'likes'])->findOrFail($quoteId);
        $comment = Comment::create([
            'content' => $request->input('content'),
            'user_id' => auth()->id(),
            'quote_id' => $quoteId,
        ]);

        $commentCount = $quote->comments()->count();

        event(new QuoteCommented($quote, $comment, $user, $commentCount));

        $comment->load('user');
        return response()->json(['message' => 'Comment added successfully!', 'comment' => $comment,'commentCount' =>  $commentCount], 201);
    }


    public function index($quoteId)
    {
        $quote = Quote::findOrFail($quoteId);
        $comments = $quote->comments()->with('user')->oldest()->get();
        return response()->json($comments);
    }
}
