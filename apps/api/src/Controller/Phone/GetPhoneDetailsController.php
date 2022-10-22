<?php

declare(strict_types=1);

namespace App\Controller\Phone;

use App\Controller\ExtendedAbstractController;
use App\Entity\Phone;
use App\HttpResource\HttpResourceFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetPhoneDetailsController extends ExtendedAbstractController
{
    public function __construct(private readonly HttpResourceFactory $httpResourceFactory)
    {
    }

    #[Route('/api/phones/{id}', name: 'api_phones_show', methods: ['GET'])]
    public function __invoke(Phone $phone): Response
    {
        $this->denyAccessUnlessGranted('view', $phone);

        return $this->json(
            $this->httpResourceFactory->create($phone, 'api_phones_', ['groups' => ['phone:read']]),
            Response::HTTP_OK,
            [],
        );
    }
}
