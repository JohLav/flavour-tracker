<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Restaurant>
 *
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurant[]    findAll()
 * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }

    public function save(Restaurant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Restaurant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findFiltered(array $filters): array
    {
        $qb = $this->createQueryBuilder('r')
            ->leftJoin('r.items', 'i')
            ->leftJoin('r.menus', 'm')
            ->leftJoin('r.timeSlots', 't')
            ->leftJoin('r.category', 'c');


        if (!empty($filters['item'])) {
            $qb->andWhere($qb->expr()->like('i.name', ':item'))
                ->setParameter('item', '%' . $filters['item'] . '%');
        }

        if (!empty($filters['city'])) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('r.address', ':city'),
                $qb->expr()->like('r.zip_code', ':city')
            ))
                ->setParameter('city', '%' . $filters['city'] . '%');
        }

        if (!empty($filters['timeSlot'])) {
            $qb->andWhere($qb->expr()->andX(
                $qb->expr()->lte('t.opening', ':time'),
                $qb->expr()->gte('t.closing', ':time'),
                $qb->expr()->eq('t.day', ':day')
            ))
                ->setParameter('time', $filters['timeSlot'])
                ->setParameter('day', $filters['timeSlot']);
        }

        if (!empty($filters['menu'])) {
            $qb->andWhere($qb->expr()->like('m.name', ':menu'))
               ->setParameter('menu', '%' . $filters['menu'] . '%');
        }

        if (!empty($filters['category'])) {
            $qb->andWhere('r.category = :category')
                ->setParameter('category', $filters['category']);
        }

        if (!empty($filters['diet'])) {
            $qb->andWhere('d.name IN (:diets)')
                ->setParameter('diet', $filters['diet']);
        }

        if (!empty($filters['price'])) {
            $qb->andWhere($qb->expr()->andX(
                $qb->expr()->lte('i.price', ':maxPrice'),
                $qb->expr()->gte('m.reduction', ':minReduction')
            ))
                ->setParameter('maxPrice', $filters['priceRange']['maxPrice'])
                ->setParameter('minReduction', $filters['priceRange']['minReduction']);
        }

        return $qb->getQuery()->getResult();
    }


//    /**
//     * @return Restaurant[] Returns an array of Restaurant objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Restaurant
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
