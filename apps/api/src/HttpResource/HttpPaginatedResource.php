<?php

declare(strict_types=1);

namespace App\HttpResource;

class HttpPaginatedResource
{
    /** @var array<string, string> */
    private array $links;

    /**
     * @param array<HttpResource> $items
     */
    public function __construct(
        public readonly array $items,
        string $currentPage,
        string $lastPage,
        string $firstPage,
        ?string $nextPage = null,
        ?string $previousPage = null,
    ) {
        $this->links = [
            'self' => $currentPage,
            'last' => $lastPage,
            'first' => $firstPage,
        ];

        if ($nextPage !== null) {
            $this->links['next'] = $nextPage;
        }

        if ($previousPage !== null) {
            $this->links['previous'] = $previousPage;
        }
    }

    /**
     * @return array<string, string>
     */
    public function getLinks(): array
    {
        return $this->links;
    }
}
