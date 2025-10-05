<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SnippetController;

Route::get('/', function () {
    return view('index');
})->name('home');

// Snippet routes
Route::prefix('snippets')->name('snippets.')->group(function () {
    Route::get('/my', [SnippetController::class, 'index'])->name('index');
    Route::get('/add', [SnippetController::class, 'create'])->name('create');
    Route::post('/add', [SnippetController::class, 'store'])->name('store');
    Route::get('/{snippet}/edit', [SnippetController::class, 'edit'])->name('edit');
    Route::post('/{snippet}/edit', [SnippetController::class, 'update'])->name('update');
    Route::post('/{snippet}/delete', [SnippetController::class, 'destroy'])->name('destroy');
    Route::get('/{snippet}/json', [SnippetController::class, 'json'])->name('json');
});

use App\Http\Controllers\AuthController;

// Authentication routes (simple)
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
