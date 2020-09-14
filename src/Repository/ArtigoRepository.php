<?php

namespace App\Repository;

use App\Entity\Artigo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Artigo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artigo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artigo[]    findAll()
 * @method Artigo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtigoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artigo::class);
    }

    // /**
    //  * @return Artigo[] Returns an array of Artigo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Artigo
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
