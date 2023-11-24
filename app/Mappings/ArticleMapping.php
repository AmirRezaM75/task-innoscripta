<?php

declare(strict_types=1);

namespace App\Mappings;

class ArticleMapping extends MappingHandler
{
    public static function getIndexName(): string
    {
        return 'articles';
    }

    public function getMappingDefinition(): array
    {
        return [
            'properties' => [
                'id' => [
                    'type' => 'unsigned_long',
                ],
                'title' => [
                    'type' => 'text',
                ],
                'description' => [
                    'type' => 'text',
                ],
                'publishedAt' => [
                    'type' => 'date',
                    'format' => 'yyyy-MM-dd HH:mm:ss'
                ],
                'createdAt' => [
                    'type' => 'date',
                    'format' => 'yyyy-MM-dd HH:mm:ss'
                ],
                'author' => [
                    'properties' => [
                        'id' => [
                            'type' => 'unsigned_long'
                        ],
                        'slug' => [
                            'type' => 'text'
                        ],
                        'name' => [
                            'type' => 'text'
                        ]
                    ]
                ],
                'source' => [
                    'properties' => [
                        'id' => [
                            'type' => 'unsigned_long'
                        ],
                        'slug' => [
                            'type' => 'text'
                        ],
                        'name' => [
                            'type' => 'text'
                        ]
                    ]
                ],
                'category' => [
                    'properties' => [
                        'id' => [
                            'type' => 'unsigned_long'
                        ],
                        'slug' => [
                            'type' => 'text'
                        ],
                        'name' => [
                            'type' => 'text'
                        ]
                    ]
                ],
            ]
        ];
    }
}
