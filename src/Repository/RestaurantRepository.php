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
            ->leftJoin('r.items', 'items')
            ->leftJoin('r.menus', 'menus')
            ->leftJoin('r.timeSlots', 'timeSlots')
            ->leftJoin('r.category', 'category')
            ->leftJoin('menus.diets', 'diets');

        if (!empty($filters['items'])) {
            foreach ($filters['items'] as $i => $name) {
                $qb
                    ->orWhere("items.name LIKE :item{$i}")
                    ->setParameter("item{$i}", "%{$name}%")
                    ->orWhere("menus.name LIKE :menu{$i}")
                    ->setParameter("menu{$i}", "%{$name}%");
            }
        }

//        if (!empty($filters['city'])) {
//            $qb->andWhere($qb->expr()->orX(
//                $qb->expr()->like('r.address', ':city'),
//                $qb->expr()->like('r.zip_code', ':city')
//            ))
//                ->setParameter('city', '%' . $filters['city'] . '%');
//        }

        if (!empty($filters['timeSlot'])) {
            $qb->andWhere($qb->expr()->andX(
                $qb->expr()->lte('timeSlots.opening', ':time'),
                $qb->expr()->gte('timeSlots.closing', ':time'),
                $qb->expr()->eq('timeSlots.day', ':day')
            ))
                ->setParameter('time', $filters['timeSlot']->format('H:i'))
                ->setParameter('day', $filters['timeSlot']->format('N'));
        }

        if (!empty($filters['category'])) {
            $qb->andWhere('r.category = :category')
                ->setParameter('category', $filters['category']);
        }

        if (!empty($filters['diets'])) {
            $qb->andWhere('diets IN (:diets)')
                ->setParameter('diets', $filters['diets']);
        }

        if (!empty($filters['price'])) {
            $qb->andWhere('items.price <= :maxPrice')
                // ->setParameter('minReduction', $filters['priceRange']['minReduction']);
                ->setParameter('maxPrice', $filters['price']);
        }
        return $qb->getQuery()->getResult();
    }
}
