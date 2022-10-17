<?php

declare(strict_types=1);

namespace App\Controller\CustomerUser;

use App\Controller\ExtendedAbstractController;
use App\Entity\CustomerUser;
use App\Factory\HttpResource\CustomerUserResourceFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetCustomerUserDetailsController extends ExtendedAbstractController
{
    public function __construct(private readonly CustomerUserResourceFactory $customerUserResourceFactory)
    {
    }

    #[Route('/api/customer_users/{id}', name: 'api_customer_users_show', methods: ['GET'])]
    public function __invoke(CustomerUser $customerUser): Response
    {
        $this->denyAccessUnlessGranted('view', $customerUser);

        return $this->json($this->customerUserResourceFactory->create($customerUser));
    }
}
