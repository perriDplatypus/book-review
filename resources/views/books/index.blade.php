@extends('layouts.app')

@section('content')
    <h1 class="mb-10 text-2xl">Books</h1>

    <form method="GET" action="{{ route(name: 'books.index') }}" class="mb-4 flex items-center space-x-2">
        <input type="text" name="title" class="input h-10" placeholder="Search by title.."
            value="{{ request(key: 'title') }}" />
        <button type="submit" class="btn h-10">Search</button>
        <a href="{{ route(name: 'books.index') }}" class="btn h-10">Clear</a>
    </form>

    <ul>
        @forelse ($books as $book)
            <li class="mb-4">
                <div class="book-item">
                    <div class="flex flex-wrap items-center justify-between">
                        <div class="w-full flex-grow sm:w-auto">
                            <a href="{{ route(name: 'books.show', parameters: $book) }}"
                                class="book-title">{{ $book->title }}</a>
                            <span class="book-author">by {{ $book->author }}</span>
                        </div>
                        <div>
                            <div class="book-rating">
                                {{ number_format(num: $book->reviews_avg_rating, decimals: 1) }}
                            </div>
                            <div class="book-review-count">
                                out of {{ $book->reviews_count }}
                                {{ Str::plural(value: 'review', count: $book->reviews_count) }}
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li class="mb-4">
                <div class="empty-book-item">
                    <p class="empty-text">No books found</p>
                    <a href="{{ route(name: 'books.index') }}" class="reset-link">Reset criteria</a>
                </div>
            </li>
        @endforelse
    </ul>
@endsection
