<?php

namespace App\Repository;

use App\Entity\CompanySchoolContract;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<CompanySchoolContract>
 *
 * @implements PasswordUpgraderInterface<CompanySchoolContract>
 *
 * @method CompanySchoolContract|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanySchoolContract|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanySchoolContract[]    findAll()
 * @method CompanySchoolContract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanySchoolContractRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanySchoolContract::class);
    }

    public function create(): CompanySchoolContract
    {
        $item = new CompanySchoolContract();

        return $item;
    }

    public function add(CompanySchoolContract $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CompanySchoolContract $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CompanySchoolContract[] Returns an array of CompanySchoolContract objects
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

//    public function findOneBySomeField($value): ?CompanySchoolContract
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
