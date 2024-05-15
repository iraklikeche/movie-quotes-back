<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store($quoteId)
    {
        $like = Like::where('user_id', auth()->id())->where('quote_id', $quoteId)->first();

        if ($like) {
            $like->delete();
        } else {
            $like = Like::create([
                'user_id' => auth()->id(),
                'quote_id' => $quoteId,
            ]);
        }

        return response()->json(['message' => 'Like toggled successfully!', 'like' => $like], 200);
    }
}
