<?php

namespace App\Repository;

use App\Entity\Enrolls;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Enrolls|null find($id, $lockMode = null, $lockVersion = null)
 * @method Enrolls|null findOneBy(array $criteria, array $orderBy = null)
 * @method Enrolls[]    findAll()
 * @method Enrolls[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnrollsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enrolls::class);
    }

    // /**
    //  * @return Enrolls[] Returns an array of Enrolls objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Enrolls
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
