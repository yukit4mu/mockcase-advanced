<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            書籍詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="md:w-1/3">
                            <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="w-full h-auto object-cover rounded-lg shadow-lg">
                        </div>
                        <div class="md:w-2/3">
                            <div class="flex items-center gap-4">
                                <h1 class="text-2xl font-bold">{{ $book->title }}</h1>
                                @auth
                                    <button type="button" 
                                            class="favorite-btn text-2xl {{ auth()->user()->favoriteBooks->contains($book->id) ? 'text-red-500' : 'text-gray-300' }}"
                                            data-book-id="{{ $book->id }}">
                                        {{ auth()->user()->favoriteBooks->contains($book->id) ? '♥' : '♡' }}
                                    </button>
                                @endauth
                            </div>
                            <p class="text-gray-600 mt-2">著者: {{ $book->author }}</p>
                            <p class="text-gray-600 mt-1">ISBN: {{ $book->isbn }}</p>
                            <div class="mt-4">
                                <span class="font-bold">ジャンル:</span>
                                @forelse ($book->genres as $genre)
                                    <span class="bg-gray-200 text-gray-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">{{ $genre->name }}</span>
                                @empty
                                    <span>ジャンル未設定</span>
                                @endforelse
                            </div>
                            <div class="mt-4">
                                <p class="text-gray-700">{{ $book->description }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- レビュー投稿フォーム -->
                    <div class="mt-8">
                        <h2 class="text-xl font-bold mb-4">レビューを投稿する</h2>
                        @auth
                            <form action="{{ route('reviews.store', $book) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="rating" class="block text-sm font-medium text-gray-700">評価</label>
                                    <select name="rating" id="rating" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="1">★</option>
                                        <option value="2">★★</option>
                                        <option value="3">★★★</option>
                                        <option value="4">★★★★</option>
                                        <option value="5" selected>★★★★★</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="comment" class="block text-sm font-medium text-gray-700">コメント</label>
                                    <textarea name="comment" id="comment" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                </div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    投稿する
                                </button>
                            </form>
                        @else
                            <p>レビューを投稿するには<a href="{{ route('login') }}" class="text-blue-600 hover:underline">ログイン</a>してください。</p>
                        @endauth
                    </div>

                    <!-- レビュー一覧 -->
                    <div class="mt-8">
                        <h2 class="text-xl font-bold mb-4">レビュー一覧</h2>
                        @forelse ($book->reviews as $review)
                            <div class="border-t border-gray-200 py-4">
                                <div class="flex items-center mb-2">
                                    <p class="font-semibold">{{ $review->user->name }}</p>
                                    <p class="text-gray-500 text-sm ml-4">{{ $review->created_at->format('Y/m/d') }}</p>
                                </div>
                                <div class="flex items-center">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="h-5 w-5 {{ $i < $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.368-2.448a1 1 0 00-1.175 0l-3.368 2.448c-.784.57-1.838-.197-1.539-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.05 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z" />
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-gray-700 mt-2">{{ $review->comment }}</p>
                                <div class="mt-2 flex items-center gap-4">
                                    @auth
                                        <button type="button" 
                                                class="like-btn flex items-center gap-1 text-sm {{ $review->likedByUsers->contains(auth()->id()) ? 'text-pink-500' : 'text-gray-400' }}"
                                                data-review-id="{{ $review->id }}">
                                            <span class="like-icon">{{ $review->likedByUsers->contains(auth()->id()) ? '♥' : '♡' }}</span>
                                            <span class="like-count">{{ $review->likedByUsers->count() }}</span>
                                        </button>
                                    @else
                                        <span class="text-sm text-gray-400">
                                            ♥ {{ $review->likedByUsers->count() }}
                                        </span>
                                    @endauth
                                </div>
                            </div>
                        @empty
                            <p>まだレビューはありません。</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // お気に入りボタン
        document.querySelectorAll('.favorite-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                const bookId = this.dataset.bookId;
                const response = await fetch(`/books/${bookId}/favorite`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                });
                const data = await response.json();
                this.textContent = data.is_favorited ? '♥' : '♡';
                this.classList.toggle('text-red-500', data.is_favorited);
                this.classList.toggle('text-gray-300', !data.is_favorited);
            });
        });

        // いいねボタン
        document.querySelectorAll('.like-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                const reviewId = this.dataset.reviewId;
                const response = await fetch(`/reviews/${reviewId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                });
                const data = await response.json();
                this.querySelector('.like-icon').textContent = data.is_liked ? '♥' : '♡';
                this.querySelector('.like-count').textContent = data.likes_count;
                this.classList.toggle('text-pink-500', data.is_liked);
                this.classList.toggle('text-gray-400', !data.is_liked);
            });
        });
    </script>
    @endpush
</x-app-layout>