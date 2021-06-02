<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\SnippetsController;

//index page
Route::get('/', [IndexController::class, 'index'])->name('home');
Route::post('/build', [IndexController::class, 'build']);

//snippets page
Route::get('/snippets', [SnippetsController::class, 'index']);
