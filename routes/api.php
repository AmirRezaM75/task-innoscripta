<?php

declare(strict_types=1);

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SourceController;
use Illuminate\Support\Facades\Route;

Route::get('sources', [SourceController::class, 'index']);
Route::get('categories', [CategoryController::class, 'index']);
