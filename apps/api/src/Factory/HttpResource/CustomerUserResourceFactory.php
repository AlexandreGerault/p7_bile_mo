<?php

declare(strict_types=1);

namespace App\Factory\HttpResource;

use App\Entity\CustomerUser;
use App\HttpResource\CustomerUserResource;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CustomerUserResourceFactory
{
    public function __construct(private readonly NormalizerInterface $serializer)
    {
    }

    public function create(CustomerUser $customerUser): CustomerUserResource
    {
        /** @var array<string, string> $data */
        $data = $this->serializer->normalize($customerUser, 'json', ['groups' => ['customer_user:read']]);

        $links = [];

        return new CustomerUserResource($data, $links);
    }
}
