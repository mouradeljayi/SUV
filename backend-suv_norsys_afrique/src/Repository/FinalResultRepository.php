<?php

namespace App\Repository;

use App\Entity\FinalResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FinalResult>
 *
 * @method FinalResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method FinalResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method FinalResult[]    findAll()
 * @method FinalResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FinalResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FinalResult::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(FinalResult $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(FinalResult $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return FinalResult[] Returns an array of FinalResult objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FinalResult
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findActivite()
    {
        return $this->createQueryBuilder('t')
            ->select('IDENTITY(t.pac) as pac')
            ->groupBy('t.pac')
            ->getQuery()
            ->getResult()
            ;
    }
}
