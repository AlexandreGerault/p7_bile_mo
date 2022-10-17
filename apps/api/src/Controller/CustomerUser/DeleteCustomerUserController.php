<?php

declare(strict_types=1);

namespace App\Controller\CustomerUser;

use App\Controller\ExtendedAbstractController;
use App\Entity\CustomerUser;
use App\Manager\CustomerUserManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteCustomerUserController extends ExtendedAbstractController
{
    public function __construct(private readonly CustomerUserManagerInterface $entityManager)
    {
    }

    #[Route('/api/customer_users/{id}', name: 'api_customer_users_delete', methods: ['DELETE'])]
    public function __invoke(CustomerUser $customerUser): Response
    {
        $this->denyAccessUnlessGranted('delete', $customerUser);

        $this->entityManager->delete($customerUser);

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
