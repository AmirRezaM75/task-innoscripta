<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        /** @var Author $author */
        $author = $this->resource;

        return [
            'id' => $author->id,
            'name' => $author->name,
            'slug' => $author->slug,
        ];
    }
}
