<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Quote;
use Illuminate\Http\Request;

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
        $comment->user->append('profile_image_url');

        return response()->json(['message' => 'Comment added successfully!', 'comment' => $comment], 201);
    }


    public function index($quoteId)
    {
        $quote = Quote::findOrFail($quoteId);
        $comments = $quote->comments()->with('user')->latest()->get();

        $comments->each(function ($comment) {
            $comment->user->append('profile_image_url'); 
        });

        return response()->json($comments);
    }
}
