<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $title = $request->input(key: 'title');
        $filter = $request->input(key: 'filter', default: '');

        $books = Book::when(
            value: $title,
            callback: fn(Builder $query, $title): mixed => $query->title($title)
        );

        $books = match ($filter) {
            'popular_last_month' => $books->popularLastMonth()
            , 'popular_last_6months' => $books->popularLast6Months()
            , 'highest_rated_last_month' => $books->highestRatedLastMonth()
            , 'highest_rated_last_6months' => $books->highestRatedLast6Months()
            , default => $books->latest()
        };

        $books = $books->get();

        //$books = Cache::remember(key: 'books', ttl: 3600, callback: fn() => $books->get());

        return view(view: 'books.index', data: ['books' => $books]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(Book $book): View
    {
        return view(
            view: 'books.show'
            ,
            data: [
                'book' => $book->load(
                    relations: [
                        'reviews' => fn($query): mixed => $query->latest()
                    ]
                )
            ]
        );
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): void
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): void
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        //
    }

}