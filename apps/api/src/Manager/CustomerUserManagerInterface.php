<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\CustomerUser;

interface CustomerUserManagerInterface
{
    public function save(CustomerUser $customerUser): void;
}
