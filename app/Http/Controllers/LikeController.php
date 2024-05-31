<?php

namespace App\Http\Controllers;

use App\Events\QuoteLiked;
use App\Events\QuoteUnliked;
use App\Models\Like;
use App\Models\Quote;

class LikeController extends Controller
{
    public function store($quoteId)
    {
        $user = auth()->user();
        $quote = Quote::with(['user'])->findOrFail($quoteId);

        $like = Like::where('user_id', $user->id)->where('quote_id', $quoteId)->first();

        if ($like) {
            $like->delete();
            $likeCount = $quote->likes()->count();
            $likedByUser = false;
            event(new QuoteUnliked($quote, $user, $likeCount));

            return response()->json(['message' => 'Like removed successfully!', 'like_count' => $likeCount,'liked_by_user' => $likedByUser]);
        } else {
            Like::create([
                'user_id' => $user->id,
                'quote_id' => $quoteId,
            ]);
            $likedByUser = true;
            $likeCount = $quote->likes()->count();

            event(new QuoteLiked($quote, $user, $likeCount));

            return response()->json(['message' => 'Like added successfully!', 'like_count' => $likeCount,'liked_by_user' => $likedByUser]);
        }

    }
}
