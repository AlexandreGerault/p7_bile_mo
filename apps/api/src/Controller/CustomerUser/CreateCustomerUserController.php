<?php

declare(strict_types=1);

namespace App\Controller\CustomerUser;

use App\Entity\CustomerUser;
use App\Factory\CustomerUserFactory;
use App\Manager\CustomerUserManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateCustomerUserController extends AbstractController
{
    public function __construct(
        private readonly CustomerUserManagerInterface $entityManager,
        private readonly SerializerInterface $serializer,
    )
    {
    }

    #[Route('/api/customer_users', name: 'api_customer_users', methods: ['POST'])]
    public function __invoke(Request $request, ValidatorInterface $validator): Response
    {
        $payload = json_encode($request->request->all());

        $customerUser = $this->serializer->deserialize($payload, CustomerUser::class, 'json');

        $errors = $validator->validate($customerUser);

        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->entityManager->save($customerUser);

        return $this->json($customerUser, Response::HTTP_CREATED, context: ['groups' => ['customer_user:read']]);
    }
}
