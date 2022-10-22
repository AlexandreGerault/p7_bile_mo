<?php

declare(strict_types=1);

namespace App\Controller\CustomerUser;

use App\Controller\ExtendedAbstractController;
use App\Entity\CustomerUser;
use App\HttpResource\HttpResourceFactory;
use App\Manager\CustomerUserManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateCustomerUserController extends ExtendedAbstractController
{
    public function __construct(
        private readonly CustomerUserManagerInterface $entityManager,
        private readonly SerializerInterface $serializer,
        private readonly HttpResourceFactory $customerUserResourceFactory,
    ) {
    }

    /**
     * @throws ExceptionInterface
     * @throws \Exception
     */
    #[Route('/api/customer_users', name: 'api_customer_users_create', methods: ['POST'])]
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

        return $this->json(
            $this->customerUserResourceFactory->create(
                $customerUser,
                'api_customer_users_',
                ['groups' => ['customer_user:read']]
            ),
            Response::HTTP_CREATED,
        );
    }
}
