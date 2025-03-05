<?php

namespace App\Repository\Api\V1\Cars;

use App\Entity\Api\V1\Cars\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function getCarsList(): array
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c', 'b')
            ->join('c.brand', 'b')
            ->orderBy('b.name');

        return $qb->getQuery()->getArrayResult();
    }

    public function getCar(int $id): array
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c', 'b', 'm')
            ->join('c.brand', 'b')
            ->join('c.model', 'm')
            ->where('c.id = :id')
            ->setParameter('id', $id);

        return current($qb->getQuery()->getArrayResult());
    }

    public function getPrices(): array
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c.price')
            ->distinct();

        return $qb->getQuery()->getSingleColumnResult();
    }
}