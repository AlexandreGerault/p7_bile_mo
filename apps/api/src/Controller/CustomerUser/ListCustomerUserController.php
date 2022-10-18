<?php

declare(strict_types=1);

namespace App\Controller\CustomerUser;

use App\Controller\ExtendedAbstractController;
use App\HttpResource\HttpPaginatedCustomerUserResource;
use App\HttpResource\Pagination\PaginatedResourceFactoryInterface;
use App\Repository\CustomerUserRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListCustomerUserController extends ExtendedAbstractController
{
    public function __construct(
        private readonly CustomerUserRepositoryInterface $customerUserRepository,
        private readonly PaginatedResourceFactoryInterface $resourceFactory
    ) {
    }

    #[Route('/api/customer_users', name: 'api_customer_users_list', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $page = (int) $request->get('page', 1);

        $perPage = (int) $request->get('limit', 10);

        $users = $this->customerUserRepository->findAllPaginated($page, $perPage);

        $paginatedResource = $this->resourceFactory->create(
            $users,
            'api_customer_users_list',
            ['groups' => ['customer_user:read']]
        );

        return $this->json($paginatedResource);
    }
}
