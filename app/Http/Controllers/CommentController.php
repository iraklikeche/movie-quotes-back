<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
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

        return response()->json(['message' => 'Comment added successfully!', 'comment' => $comment], 201);
    }
}
