<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $quoteId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment = Comment::create([
            'content' => $request->input('content'),
            'user_id' => auth()->id(),
            'quote_id' => $quoteId,
        ]);

        return response()->json(['message' => 'Comment added successfully!', 'comment' => $comment], 201);
    }
}
