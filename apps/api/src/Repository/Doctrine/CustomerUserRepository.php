<?php

declare(strict_types=1);

namespace App\Repository\Doctrine;

use App\Entity\CustomerUser;
use App\HttpResource\Pagination\Collection\PaginatedCustomerUserCollection;
use App\HttpResource\Pagination\PaginatedCollection;
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

    public function findByEmail(string $email): ?CustomerUser
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function findAllPaginated(int $page, int $limit): PaginatedCollection
    {
        /** @var array<CustomerUser> $items */
        $items = $this->createQueryBuilder('cu')
            ->orderBy('cu.lastName', 'DESC')
            ->addOrderBy('cu.firstName', 'DESC')
            ->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit)
            ->getResult();

        $count = $this->count([]);

        return new PaginatedCollection(
            $items,
            $count,
            $page,
            $limit,
        );
    }
}
