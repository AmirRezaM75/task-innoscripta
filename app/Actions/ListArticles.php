<?php

declare(strict_types=1);

namespace App\Actions;

use App\Constants\TargetType;
use App\DataTransferObjects\ArticleSearchQuery;
use App\DataTransferObjects\ArticlesSearchResult;
use App\Http\Requests\ListArticlesRequest;
use App\Repository\ArticleSearchRepository;
use App\Repository\UserPreferenceRepository;

class ListArticles
{
    public function __construct(
        private readonly ArticleSearchRepository $articleSearchRepository,
        private readonly UserPreferenceRepository $userPreferenceRepository,
    ) {
    }

    public function execute(ListArticlesRequest $request): ArticlesSearchResult
    {
        $authorIds = collect();

        $categoryIds = collect();

        $sourceIds = collect();

        if ($request->preferential and $request->getAuthId()) {
            $authorIds = $authorIds->concat(
                $this->userPreferenceRepository
                    ->get($request->getAuthId(), TargetType::Author)
                    ->pluck('target_id')
                    ->all()
            );

            $categoryIds = $categoryIds->concat(
                $this->userPreferenceRepository
                    ->get($request->getAuthId(), TargetType::Category)
                    ->pluck('target_id')
                    ->all()
            );

            $sourceIds = $sourceIds->concat(
                $this->userPreferenceRepository
                    ->get($request->getAuthId(), TargetType::Source)
                    ->pluck('target_id')
                    ->all()
            );
        }

        if ($request->categoryId) {
            $categoryIds->push($request->categoryId);
        }

        if ($request->authorId) {
            $authorIds->push($request->authorId);
        }

        if ($request->sourceId) {
            $sourceIds->push($request->sourceId);
        }

        $query = new ArticleSearchQuery(
            $sourceIds->unique()->all(),
            $categoryIds->unique()->all(),
            $authorIds->unique()->all(),
            $request->q,
            $request->page,
            $request->pageSize,
        );

        return $this->articleSearchRepository->get($query);
    }
}
