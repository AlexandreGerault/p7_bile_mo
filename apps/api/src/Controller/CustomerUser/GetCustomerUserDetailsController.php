<?php

declare(strict_types=1);

namespace App\Controller\CustomerUser;

use Symfony\Component\Routing\Annotation\Route;

class GetCustomerUserDetailsController
{
    #[Route('/api/customer_users/{id}', name: 'api_customer_users_show', methods: ['GET'])]
    public function __invoke(): void
    {
    }
}
