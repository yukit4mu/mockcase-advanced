<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            評価ランキング TOP 10
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($books->isEmpty())
                        <p class="text-gray-500">レビューが投稿された書籍がまだありません。</p>
                    @else
                        <div class="space-y-4">
                            @foreach($books as $index => $book)
                                @php
                                    $rank = $index + 1;
                                    $rankClass = match($rank) {
                                        1 => 'bg-yellow-400 text-yellow-900',
                                        2 => 'bg-gray-300 text-gray-700',
                                        3 => 'bg-orange-300 text-orange-900',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                    $borderClass = $rank <= 3 ? 'border-yellow-400 bg-yellow-50' : '';
                                @endphp
                                <a href="{{ route('books.show', $book) }}" 
                                   class="flex items-center gap-4 p-4 border rounded-lg hover:shadow-lg transition {{ $borderClass }}">
                                    <!-- 順位 -->
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center font-bold {{ $rankClass }}">
                                        {{ $rank }}
                                    </div>

                                    <!-- 書籍画像 -->
                                    @if($book->image_url)
                                        <img src="{{ $book->image_url }}" alt="{{ $book->title }}" class="w-16 h-20 object-cover rounded flex-shrink-0">
                                    @else
                                        <div class="w-16 h-20 bg-gray-200 flex items-center justify-center rounded flex-shrink-0">
                                            <span class="text-gray-400 text-xs">No Image</span>
                                        </div>
                                    @endif

                                    <!-- 書籍情報 -->
                                    <div class="flex-grow min-w-0">
                                        <h3 class="font-bold text-lg text-blue-600 truncate">{{ $book->title }}</h3>
                                        <p class="text-gray-600 text-sm">{{ $book->author }}</p>
                                        <p class="text-gray-500 text-xs">({{ $book->reviews_count }}件のレビュー)</p>
                                    </div>

                                    <!-- 平均評価 -->
                                    <div class="flex-shrink-0 text-right">
                                        <div class="text-2xl font-bold text-yellow-500">
                                            {{ number_format($book->reviews_avg_rating, 2) }}
                                        </div>
                                        <div class="text-yellow-400 text-sm">
                                            @for($i = 1; $i <= 5; $i++)
                                                {{ $i <= round($book->reviews_avg_rating) ? '★' : '☆' }}
                                            @endfor
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>