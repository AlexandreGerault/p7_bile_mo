<?php

declare(strict_types=1);

namespace App\HttpResource\Pagination;

use Symfony\Component\Serializer\Exception\ExceptionInterface;

interface PaginatedResourceFactoryInterface
{
    /**
     * @param array{groups: mixed} $options
     * @throws ExceptionInterface
     */
    public function create(PaginatedCollection $collection, string $routePrefix, string $routeName, array $options): PaginatedResources;
}
