<?php

declare(strict_types=1);

namespace App\Mappings;

interface Mapping
{
    public function create(): void;

    public function drop(): void;

    public function exists(): bool;

    /** @return array<string, array<string, mixed>>*/
    public function getMappingDefinition(): array;

    public static function getIndexName(): string;
}
