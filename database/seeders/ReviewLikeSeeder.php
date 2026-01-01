<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewLikeSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $reviews = Review::all();

        foreach ($reviews as $review) {
            $likeCount = rand(0, 3);
            if ($likeCount > 0) {
                $likers = $users->random($likeCount);
                $review->likedByUsers()->attach($likers->pluck('id'));
            }
        }
    }
}