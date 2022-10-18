<?php

declare(strict_types=1);

namespace App\HttpResource\Pagination;

class PaginatedCollection
{
    /**
     * @template T
     * @param array<T> $items
     */
    public function __construct(
        public readonly array $items,
        public readonly int $totalItems,
        public readonly int $page,
        public readonly int $perPage,
    ) {
    }
}
