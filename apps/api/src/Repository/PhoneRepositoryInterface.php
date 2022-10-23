<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CustomerUser;
use App\Entity\Phone;
use App\HttpResource\Pagination\PaginatedCollection;

interface PhoneRepositoryInterface
{
    /** @return Phone[] */
    public function all(): array;

    public function findAllPaginated(int $page, int $limit): PaginatedCollection;
}
