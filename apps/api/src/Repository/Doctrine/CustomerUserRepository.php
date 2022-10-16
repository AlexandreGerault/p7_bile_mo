<?php

declare(strict_types=1);

namespace App\Repository\Doctrine;

use App\Entity\CustomerUser;
use App\Repository\CustomerUserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends ServiceEntityRepository<CustomerUser> */
class CustomerUserRepository extends ServiceEntityRepository implements CustomerUserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerUser::class);
    }

    public function all(): array
    {
        return $this->findAll();
    }
}
