<?php

use App\Http\Controllers\BookController;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

Route::get(uri: '/', action: function (): View {
    return view(view: 'welcome');
});

Route::resource(name: 'books', controller: BookController::class);