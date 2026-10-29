<?php

namespace App\Repository;

use App\Entity\Espace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Espace>
 */
class EspaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Espace::class);
    }

    public function search(string $searchText, ?int $maxPrice, ?int $minSurface, int $limit = 9, int $offset = 0): Paginator
    {
        $qb = $this->createQueryBuilder('e')
            ->addSelect('p')
            ->leftJoin('e.photoEspaces', 'p')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('e.cpEsp', 'DESC');

        if (!(empty($searchsearchText))) {
            $qb->andWhere('e.adresseEsp LIKE :txt
                OR e.villeEsp LIKE :txt
                OR e.cpEsp LIKE :txt
                OR e.adresseEsp LIKE :txt
                OR e.descEsp LIKE :txt
                OR e.titreEsp LIKE :txt
            ')
                ->setParameter('txt', '%'.$searchText.'%');
        }
        if ($maxPrice) {
            $qb->andWhere('e.tarif <= :maxPrice')
                ->setParameter('maxPrice', $maxPrice);
        }

        if ($minSurface) {
            $qb->andWhere('e.surface <= :minSurface')
                ->setParameter('minSurface', $minSurface);
        }

        return new Paginator($qb->getQuery(), true);
    }

    public function searchByUser(UserInterface $user, int $limit = 9, int $offset = 0): Paginator
    {
        $qb = $this->createQueryBuilder('e')
            ->addSelect('p')
            ->leftJoin('e.photoEspaces', 'p')
            ->leftJoin('e.utilisateurs', 'u')
            ->where('e.owner = :user')
            ->setParameter('user', $user)
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('e.cpEsp', 'DESC');

        return new Paginator($qb->getQuery(), true);
    }

    public function findLatest3(): array
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->orderBy('e.datePubliEsp', 'DESC') // Les derniers ID créés en premier
            ->setMaxResults(3)        // On en prend seulement 3
            ->getQuery()
            ->getResult();
    }
    //    /**
    //     * @return Espace[] Returns an array of Espace objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Espace
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
