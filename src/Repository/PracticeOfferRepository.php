<?php

namespace App\Repository;

use App\Entity\PracticeOffer;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<PracticeOffer>
 *
 * @implements PasswordUpgraderInterface<PracticeOffer>
 *
 * @method PracticeOffer|null find($id, $lockMode = null, $lockVersion = null)
 * @method PracticeOffer|null findOneBy(array $criteria, array $orderBy = null)
 * @method PracticeOffer[]    findAll()
 * @method PracticeOffer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PracticeOfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PracticeOffer::class);
    }

    public function create(): PracticeOffer
    {
        $item = new PracticeOffer();

        return $item;
    }

    public function add(PracticeOffer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PracticeOffer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PracticeOffer[] Returns an array of PracticeOffer objects
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

//    public function findOneBySomeField($value): ?PracticeOffer
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
