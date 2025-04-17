<?php

namespace App\Repository;

use App\Entity\Vibe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vibe>
 */
class VibeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vibe::class);
    }

    public function findByProfileIdWithRelations(int $profileId): array
    {
        return $this->createQueryBuilder('v')
            ->leftJoin('v.image', 'i')->addSelect('i')
            ->leftJoin('v.playlist', 'p')->addSelect('p')
            ->leftJoin('v.profile', 'pr')->addSelect('pr')
            ->andWhere('pr.id = :id')
            ->setParameter('id', $profileId)
            ->getQuery()
            ->getResult();
    }


    //    /**
    //     * @return Vibe[] Returns an array of Vibe objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Vibe
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
