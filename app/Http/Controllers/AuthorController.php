<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\ListAuthors;
use App\Http\Resources\AuthorResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorController extends Controller
{
    public function index(ListAuthors $action): JsonResource
    {
        $authors = $action->execute();

        return AuthorResource::collection($authors);
    }
}
