<?php

declare(strict_types=1);

namespace App\HttpResource\Pagination;

use App\HttpResource\HttpResourceFactory;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaginatedResourceFactory implements PaginatedResourceFactoryInterface
{
    public function __construct(
        private readonly HttpResourceFactory $httpResourceFactory,
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function create(PaginatedCollection $collection, string $routePrefix, string $routeName, array $options): PaginatedResources
    {
        $items = array_map(
            fn($item) => $this->httpResourceFactory->create($item, $routePrefix, $options),
            $collection->items
        );

        $currentPage = $collection->page;
        $lastPage = (int)ceil($collection->totalItems / $collection->perPage);
        $perPage = $collection->perPage;

        return new PaginatedResources(
            items: $items,
            currentPage: $this->urlGenerator->generate($routeName, ['page' => $currentPage, 'limit' => $perPage]),
            lastPage: $this->urlGenerator->generate($routeName, ['page' => $lastPage, 'limit' => $perPage]),
            firstPage: $this->urlGenerator->generate($routeName, ['page' => 1, 'limit' => $perPage]),
            nextPage: $currentPage < $lastPage
                ? $this->urlGenerator->generate($routeName, ['page' => $currentPage + 1, 'limit' => $perPage])
                : null,
            previousPage: $currentPage > 1
                ? $this->urlGenerator->generate($routeName, ['page' => $currentPage - 1, 'limit' => $perPage])
                : null,
        );
    }
}
