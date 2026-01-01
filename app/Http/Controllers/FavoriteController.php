<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    /**
     * お気に入り一覧を表示
     */
    public function index(Request $request): View
    {
        $books = $request->user()
            ->favoriteBooks()
            ->with('genres')
            ->latest('favorites.created_at')
            ->paginate(10);

        return view('favorites.index', compact('books'));
    }

    /**
     * お気に入りを追加/削除（トグル）
     */
    public function toggle(Request $request, Book $book): JsonResponse
    {
        $user = $request->user();
        $isFavorited = $user->favoriteBooks()->where('book_id', $book->id)->exists();

        if ($isFavorited) {
            $user->favoriteBooks()->detach($book->id);
            $message = 'お気に入りから削除しました。';
        } else {
            $user->favoriteBooks()->attach($book->id);
            $message = 'お気に入りに追加しました。';
        }

        return response()->json([
            'is_favorited' => !$isFavorited,
            'message' => $message,
        ]);
    }
}