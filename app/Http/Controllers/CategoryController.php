<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\ListCategories;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryController extends Controller
{
    public function index(ListCategories $action): JsonResource
    {
        $categories = $action->execute();

        return CategoryResource::collection($categories);
    }
}
