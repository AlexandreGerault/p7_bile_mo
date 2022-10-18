<?php

declare(strict_types=1);

namespace App\HttpResource\Pagination;

use App\HttpResource\HttpPaginatedResource;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

interface PaginatedResourceFactoryInterface
{
    /**
     * @param array{groups: mixed} $options
     * @throws ExceptionInterface
     */
    public function create(PaginatedCollection $collection, string $routeName, array $options): HttpPaginatedResource;
}
