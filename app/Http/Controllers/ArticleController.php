<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\ListArticles;
use App\Http\Requests\ListArticlesRequest;
use App\Http\Responses\ListArticlesResponse;

class ArticleController extends Controller
{
    public function index(ListArticlesRequest $request, ListArticles $action): ListArticlesResponse
    {
        $result = $action->execute($request);

        return new ListArticlesResponse($result);
    }
}
