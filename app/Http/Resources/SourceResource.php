<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SourceResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        /** @var Source $source */
        $source = $this->resource;

        return [
            'id' => $source->id,
            'name' => $source->name,
            'slug' => $source->slug,
        ];
    }
}
