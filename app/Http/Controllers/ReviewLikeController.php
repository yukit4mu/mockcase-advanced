<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewLikeController extends Controller
{
    public function toggle(Request $request, Review $review): JsonResponse
    {
        $user = $request->user();
        $isLiked = $review->likedByUsers()->where('user_id', $user->id)->exists();

        if ($isLiked) {
            $review->likedByUsers()->detach($user->id);
        } else {
            $review->likedByUsers()->attach($user->id);
        }

        return response()->json([
            'is_liked' => !$isLiked,
            'likes_count' => $review->likedByUsers()->count(),
        ]);
    }
}