<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Quote;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store($quoteId)
    {
        $user = auth()->user();
        $quote = Quote::findOrFail($quoteId);

        $like = Like::where('user_id', $user->id)->where('quote_id', $quoteId)->first();

        if ($like) {
            $like->delete();
            $likeCount = $quote->likes()->count();
            $likedByUser = false;

            return response()->json(['message' => 'Like removed successfully!', 'like_count' => $likeCount,'liked_by_user' => $likedByUser]);
        } else {
            Like::create([
                'user_id' => $user->id,
                'quote_id' => $quoteId,
            ]);
            $likedByUser = true;

            $likeCount = $quote->likes()->count();
            return response()->json(['message' => 'Like added successfully!', 'like_count' => $likeCount,'liked_by_user' => $likedByUser]);
        }

    }
}
