<?php

namespace App\Repository;

use App\Entity\StudyProgram;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<StudyProgram>
 *
 * @implements PasswordUpgraderInterface<StudyProgram>
 *
 * @method StudyProgram|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudyProgram|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudyProgram[]    findAll()
 * @method StudyProgram[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudyProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudyProgram::class);
    }

    public function create(): StudyProgram
    {
        $item = new StudyProgram();

        return $item;
    }

    public function add(StudyProgram $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StudyProgram $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return StudyProgram[] Returns an array of StudyProgram objects
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

//    public function findOneBySomeField($value): ?StudyProgram
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
