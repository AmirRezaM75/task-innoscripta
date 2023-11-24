<?php

declare(strict_types=1);

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SourceController;
use Illuminate\Support\Facades\Route;

Route::get('sources', [SourceController::class, 'index']);
Route::get('categories', [CategoryController::class, 'index']);
Route::get('authors', [AuthorController::class, 'index']);
Route::get('articles', [ArticleController::class, 'index']);
