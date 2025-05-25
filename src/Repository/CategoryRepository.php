<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

        /**
       * @return Category[] Returns an array of Category objects
       */
      public function findByExampleField($value): array
           {
            return $this->createQueryBuilder('c')
                ->leftJoin('c.movies', 'm')
                ->select('m')
                ->orderBy('c.name', 'ASC')
                ->addOrderBy('m.createdAt', 'DESC')
                ->getQuery()
                ->getResult();
           }

}
