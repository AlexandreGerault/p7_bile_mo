<?php

declare(strict_types=1);

namespace App\Controller\CustomerUser;

use App\Controller\ExtendedAbstractController;
use App\Entity\Customer;
use App\Entity\CustomerUser;
use App\Factory\CustomerUserFactory;
use App\Manager\CustomerUserManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use League\Bundle\OAuth2ServerBundle\Manager\ClientManagerInterface;
use League\Bundle\OAuth2ServerBundle\Security\User\NullUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateCustomerUserController extends ExtendedAbstractController
{
    public function __construct(
        private readonly CustomerUserManagerInterface $entityManager,
        private readonly SerializerInterface $serializer,
    ) {
    }

    #[Route('/api/customer_users', name: 'api_customer_users', methods: ['POST'])]
    public function __invoke(Request $request, ValidatorInterface $validator): Response
    {
        $customer = $this->getOAuthClient();

        $payload = json_encode($request->request->all());

        /** @var CustomerUser $customerUser */
        $customerUser = $this->serializer->deserialize($payload, CustomerUser::class, 'json');
        $customerUser->setClient($customer);

        $errors = $validator->validate($customerUser);

        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->entityManager->save($customerUser);

        return $this->json($customerUser, Response::HTTP_CREATED, context: ['groups' => ['customer_user:read']]);
    }
}
