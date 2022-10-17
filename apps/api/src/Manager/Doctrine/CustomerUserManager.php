<?php

declare(strict_types=1);

namespace App\Manager\Doctrine;

use App\Entity\CustomerUser;
use App\Manager\CustomerUserManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

class CustomerUserManager implements CustomerUserManagerInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function save(CustomerUser $customerUser): void
    {
        $this->entityManager->persist($customerUser);
        $this->entityManager->flush();
    }

    public function delete(CustomerUser $customerUser): void
    {
        $this->entityManager->remove($customerUser);
        $this->entityManager->flush();
    }
}
