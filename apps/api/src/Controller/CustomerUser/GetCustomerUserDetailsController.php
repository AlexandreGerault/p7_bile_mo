<?php

declare(strict_types=1);

namespace App\Controller\CustomerUser;

use App\Controller\ExtendedAbstractController;
use App\Entity\CustomerUser;
use App\HttpResource\HttpResourceFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetCustomerUserDetailsController extends ExtendedAbstractController
{
    public function __construct(private readonly HttpResourceFactory $httpResourceFactory)
    {
    }

    #[Route('/api/customer_users/{id}', name: 'api_customer_users_show', methods: ['GET'])]
    public function __invoke(CustomerUser $customerUser): Response
    {
        $this->denyAccessUnlessGranted('view', $customerUser);

        return $this->json($this->httpResourceFactory->create($customerUser, ['groups' => ['customer_user:read']]));
    }
}
