<?php

namespace App\Repository\Api\V1\Credit;

use App\Entity\Api\V1\Credit\CreditProgram;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class CreditProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreditProgram::class);
    }

    public function getInterestLessThan(int $percent): ?CreditProgram
    {
        $qb = $this->createQueryBuilder('p');
        $qb->where('p.interestRate < :percent')
            ->setParameter('percent', $percent)
            ->orderBy('p.interestRate', 'DESC');

        return $qb->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }

    public function getInterestGreaterThan(int $percent): ?CreditProgram
    {
        $qb = $this->createQueryBuilder('p');
        $qb->where('p.interestRate >= :percent')
            ->setParameter('percent', $percent)
            ->orderBy('p.interestRate', 'ASC');

        return $qb->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }
}