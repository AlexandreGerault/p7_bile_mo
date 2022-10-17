<?php

declare(strict_types=1);

namespace App\Tests\Api\Helpers;

use App\Entity\CustomerUser;
use League\Bundle\OAuth2ServerBundle\Model\AbstractClient;

trait CustomerUserFactory
{
    public function create(AbstractClient $client, string $email, string $firstName, string $lastName): CustomerUser
    {
        $customerUser = new CustomerUser();
        $customerUser->setClient($client);
        $customerUser->setEmail($email);
        $customerUser->setFirstName($firstName);
        $customerUser->setLastName($lastName);

        $this->getEntityManagerInterface()->persist($customerUser);
        $this->getEntityManagerInterface()->flush();

        return $customerUser;
    }
}
