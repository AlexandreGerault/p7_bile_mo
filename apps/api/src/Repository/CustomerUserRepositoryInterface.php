<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CustomerUser;

interface CustomerUserRepositoryInterface
{
    /** @return CustomerUser[] */
    public function all(): array;
}
