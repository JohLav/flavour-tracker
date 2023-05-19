<?php

    namespace App\Repository;

    use App\Entity\Reservation;
    use App\Entity\Restaurant;
    use DateTime;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    /**
     * @extends ServiceEntityRepository<Reservation>
     *
     * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
     * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
     * @method Reservation[]    findAll()
     * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
     */
class ReservRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function save(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findReservationByTimeSlot(Restaurant $restaurant, ?DateTime $dateTime): array
    {
        $qb = $this->createQueryBuilder('r');
        $qb
            ->andWhere('r.restaurant = :restaurant')
            ->andWhere('r.datetime >= :date_start')
            ->andWhere('r.datetime <= :date_end')
            ->setParameter('date_start', $dateTime->format('Y-m-d 00:00:00'))
            ->setParameter('date_end', $dateTime->format('Y-m-d 23:59:59'))
            ->setParameter('restaurant', $restaurant);

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Reservation[] Returns an array of Reservation objects
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

//    public function findOneBySomeField($value): ?Reservation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
