<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\ListSources;
use App\Http\Resources\SourceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SourceController extends Controller
{
    public function index(ListSources $action): JsonResource
    {
        $sources = $action->execute();

        return SourceResource::collection($sources);
    }
}
