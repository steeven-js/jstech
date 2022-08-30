<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Smartphone;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Smartphone>
 *
 * @method Smartphone|null find($id, $lockMode = null, $lockVersion = null)
 * @method Smartphone|null findOneBy(array $criteria, array $orderBy = null)
 * @method Smartphone[]    findAll()
 * @method Smartphone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SmartphoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Smartphone::class);
    }

    public function add(Smartphone $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Smartphone $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Undocumented function
     *
     * @param  Search $search
     *
     * @return Smartphone []
     */
    public function findWithSearch(Search $search) {

        $query = $this
            ->createQueryBuilder('s')
            ->select('c', 's')
            ->join('s.CategorySmartphone', 'c');

        if (!empty($search->categories)) {
        $query = $query  
            ->andWhere('c.id IN (:CategorySmartphone)')
            ->setParameter('CategorySmartphone', $search->categories);
        }

        if (!empty($search->string)) {
            $query =$query  
                ->andWhere('p.name LIKE :string')
                ->setParameter('string', "%($search->string)%");
        }

        return $query->getQuery()->getResult();
    }

//    /**
//     * @return Smartphone[] Returns an array of Smartphone objects
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

//    public function findOneBySomeField($value): ?Smartphone
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
