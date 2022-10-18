<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CustomerUser;
use App\HttpResource\Pagination\PaginatedCollection;

interface CustomerUserRepositoryInterface
{
    /** @return CustomerUser[] */
    public function all(): array;

    public function findByEmail(string $email): ?CustomerUser;

    public function findAllPaginated(int $page, int $limit): PaginatedCollection;
}
