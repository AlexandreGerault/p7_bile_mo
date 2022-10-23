<?php

declare(strict_types=1);

namespace App\Controller\Phone;

use App\Controller\ExtendedAbstractController;
use App\HttpResource\Pagination\PaginatedResourceFactoryInterface;
use App\Repository\CustomerUserRepositoryInterface;
use App\Repository\PhoneRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class ListPhoneController extends ExtendedAbstractController
{
    public function __construct(
        private readonly PhoneRepositoryInterface $phoneRepository,
        private readonly PaginatedResourceFactoryInterface $resourceFactory
    ) {
    }

    /** @throws ExceptionInterface */
    #[Route('/api/phones', name: 'api_phones_list', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $page = (int) $request->get('page', 1); // @phpstan-ignore-line

        $perPage = (int) $request->get('limit', 10); // @phpstan-ignore-line

        $phones = $this->phoneRepository->findAllPaginated($page, $perPage);

        $paginatedResource = $this->resourceFactory->create(
            $phones,
            'api_phones_',
            'api_phones_list',
            ['groups' => ['phone:read']]
        );

        return $this->json($paginatedResource);
    }
}
