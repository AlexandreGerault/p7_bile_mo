<?php

declare(strict_types=1);

namespace App\Repository\Doctrine;

use App\Entity\CustomerUser;
use App\Entity\Phone;
use App\HttpResource\Pagination\PaginatedCollection;
use App\Repository\PhoneRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends ServiceEntityRepository<Phone> */
class PhoneRepository extends ServiceEntityRepository implements PhoneRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Phone::class);
    }

    public function all(): array
    {
        return $this->findAll();
    }

    public function findAllPaginated(int $page, int $limit): PaginatedCollection
    {
        /** @var array<Phone> $items */
        $items = $this->createQueryBuilder('p')
            ->orderBy('p.model', 'DESC')
            ->addOrderBy('p.createdAt', 'DESC')
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
