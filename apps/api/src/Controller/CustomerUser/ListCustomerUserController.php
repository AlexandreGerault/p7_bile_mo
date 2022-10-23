<?php

declare(strict_types=1);

namespace App\Controller\CustomerUser;

use App\Controller\ExtendedAbstractController;
use App\HttpResource\Pagination\PaginatedResourceFactoryInterface;
use App\Repository\CustomerUserRepositoryInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class ListCustomerUserController extends ExtendedAbstractController
{
    public function __construct(
        private readonly CustomerUserRepositoryInterface $customerUserRepository,
        private readonly PaginatedResourceFactoryInterface $resourceFactory,
        private readonly TagAwareCacheInterface $cache
    ) {
    }

    /**
     * @throws ExceptionInterface
     * @throws InvalidArgumentException
     */
    #[Route('/api/customer_users', name: 'api_customer_users_list', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $page = (int) $request->get('page', 1); // @phpstan-ignore-line

        $perPage = (int) $request->get('limit', 10); // @phpstan-ignore-line

        $users = $this->cache->get(
            "customer_users_{$page}_{$perPage}",
            function (ItemInterface $item) use ($page, $perPage) {
                $item->tag('customer_users');
                return $this->customerUserRepository->findAllPaginated($page, $perPage);
            }
        );

        $paginatedResource = $this->resourceFactory->create(
            $users,
            'api_customer_users_',
            'api_customer_users_list',
            ['groups' => ['customer_user:read']]
        );

        return $this->json($paginatedResource);
    }
}
