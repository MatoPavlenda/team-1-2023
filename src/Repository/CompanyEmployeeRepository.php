<?php

namespace App\Repository;

use App\Entity\CompanyEmployee;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<CompanyEmployee>
 *
 * @implements PasswordUpgraderInterface<CompanyEmployee>
 *
 * @method CompanyEmployee|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyEmployee|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyEmployee[]    findAll()
 * @method CompanyEmployee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyEmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyEmployee::class);
    }

    public function create(): CompanyEmployee
    {
        $item = new CompanyEmployee();

        return $item;
    }

    public function add(CompanyEmployee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CompanyEmployee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CompanyEmployee[] Returns an array of CompanyEmployee objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CompanyEmployee
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
