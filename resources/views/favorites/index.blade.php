<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            お気に入り一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($books->isEmpty())
                        <p class="text-gray-500">お気に入りに登録した書籍はありません。</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($books as $book)
                                <div class="border rounded-lg p-4 shadow relative">
                                    <button type="button" 
                                            class="favorite-btn absolute top-2 right-2 text-2xl text-red-500"
                                            data-book-id="{{ $book->id }}">
                                        ♥
                                    </button>
                                    <a href="{{ route('books.show', $book) }}" class="block">
                                        @if($book->image_url)
                                            <img src="{{ $book->image_url }}" alt="{{ $book->title }}" class="w-full h-48 object-cover mb-4 rounded">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center mb-4 rounded">
                                                <span class="text-gray-500">画像なし</span>
                                            </div>
                                        @endif
                                        <h3 class="font-bold text-lg mb-2 text-blue-600">{{ $book->title }}</h3>
                                        <p class="text-gray-600 text-sm mb-2">{{ $book->author }}</p>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($book->genres as $genre)
                                                <span class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded">{{ $genre->name }}</span>
                                            @endforeach
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $books->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
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
                if (!data.is_favorited) {
                    this.closest('.border').remove();
                }
            });
        });
    </script>
    @endpush
</x-app-layout>