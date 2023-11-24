<?php

declare(strict_types=1);

namespace App\Repository;

use App\DataTransferObjects\ArticleSearchQuery;
use App\DataTransferObjects\ArticlesSearchResult;
use App\Mappings\ArticleMapping;
use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use Elastic\Elasticsearch\Client;
use Illuminate\Support\Carbon;

class ArticleSearchRepositoryElastic implements ArticleSearchRepository
{
    public function __construct(private readonly Client $client)
    {
    }

    public function get(ArticleSearchQuery $query): ArticlesSearchResult
    {

        $q = [
            'bool' => [
                'must' => [],
                'filter' => [],
            ],
        ];

        if (!empty($query->q)) {
            $q['bool']['must'][] = [
                'bool' => [
                    'should' => [
                        [
                            'match' => [
                                'title' => [
                                    'query' => $query->q,
                                    'boost' => 2,
                                ]
                            ]
                        ],
                        [
                            'match' => [
                                'description' => $query->q
                            ]
                        ]
                    ]
                ]
            ];
        }

        if ($query->authorIds) {
            $q['bool']['filter'][] = [
                'terms' => [
                    'author.id' => $query->authorIds
                ]
            ];
        }

        if ($query->categoryIds) {
            $q['bool']['filter'][] = [
                'terms' => [
                    'category.id' => $query->categoryIds
                ]
            ];
        }

        if ($query->sourceIds) {
            $q['bool']['filter'][] = [
                'terms' => [
                    'source.id' => $query->sourceIds
                ]
            ];
        }

        $params = [
            'index' => ArticleMapping::getIndexName(),
            'body' => [
                'query' => $q
            ]
        ];

        $response = $this->client->search($params);

        $articles = collect();

        foreach (data_get($response, 'hits.hits', []) as $item) {
            $item = $item['_source'];

            $author = null;

            if ($item['author']) {
                $author = new Author();
                $author->id = $item['author']['id'];
                $author->name = $item['author']['name'];
                $author->slug = $item['author']['slug'];
            }

            $category = new Category();
            $category->id = $item['category']['id'];
            $category->name = $item['category']['name'];
            $category->slug = $item['category']['slug'];

            $source = new Source();
            $source->id = $item['source']['id'];
            $source->name = $item['source']['name'];
            $source->slug = $item['source']['slug'];


            $article = new Article();
            $article->id = $item['id'];
            $article->title = $item['title'];
            $article->description = $item['description'];
            $article->published_at = Carbon::parse($item['publishedAt']);
            $article->author = $author;
            $article->category = $category;
            $article->source = $source;

            $articles->push($article);
        }

        $total = data_get($response, 'hits.total.value', 0);

        return new ArticlesSearchResult(
            $total,
            $query->page,
            $query->pageSize,
            $articles,
        );
    }
}
