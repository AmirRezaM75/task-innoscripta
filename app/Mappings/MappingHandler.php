<?php

declare(strict_types=1);

namespace App\Mappings;

use App\Exceptions\MappingAlreadyExistsException;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;

abstract class MappingHandler implements Mapping
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    public function create(): void
    {
        $this->client->indices()->create(['index' => static::getIndexName()]);

        /** @phpstan-ignore-next-line */
        $response = $this->client->indices()->getMapping(['index' => static::getIndexName()])->asArray();

        if (empty($response[static::getIndexName()]['mappings'])) {
            $this->client->indices()->putMapping([
                'index' => static::getIndexName(),
                'body' => $this->getMappingDefinition()
            ]);
        } else {
            throw new MappingAlreadyExistsException();
        }
    }

    public function drop(): void
    {
        $this->client->indices()->delete(['index' => static::getIndexName()]);
    }

    public function exists(): bool
    {
        try {
            $this->client->indices()->get(['index' => static::getIndexName()]);
        } catch (ClientResponseException $exception) {
            if (str_contains($exception->getMessage(), 'index_not_found_exception')) {
                return false;
            }
        }

        return true;
    }
}
