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

    public function create(PaginatedCollection $collection, string $routeName, array $options): PaginatedResources
    {
        $items = array_map(
            fn($item) => $this->httpResourceFactory->create($item, $options),
            $collection->items
        );

        $currentPage = $collection->page;
        $lastPage = (int)ceil($collection->totalItems / $collection->perPage);

        return new PaginatedResources(
            items: $items,
            currentPage: $this->urlGenerator->generate($routeName, ['page' => $currentPage]),
            lastPage: $this->urlGenerator->generate($routeName, ['page' => $lastPage]),
            firstPage: $this->urlGenerator->generate($routeName, ['page' => 1]),
            nextPage: $currentPage < $lastPage
                ? $this->urlGenerator->generate($routeName, ['page' => $currentPage + 1])
                : null,
            previousPage: $currentPage > 1
                ? $this->urlGenerator->generate($routeName, ['page' => $currentPage - 1])
                : null,
        );
    }
}
