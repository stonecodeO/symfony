<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductSearch;
use App\Entity\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Query
    */
    public function findAllVisibleQuery(Search $search): Query
    {
        $query = $this->getSearchQuery($search);
        return $query->getQuery();
    }

    /**
     * récupere de minimum et le maximum relatif aux critères de recherche
     * @param Search $search
     * @return integer[]
     */
    public function findMinMax(Search $search): array {

        $result = $this->getSearchQuery($search,true)
                    ->select('MIN(product.price) as min','MAX(product.price) as max')
                    ->getQuery()
                    ->getScalarResult();
        ;
        return [(int)$result[0]['min'], (int)$result[0]['max']];

    }
    private function getSearchQuery(Search $search ,$ignorePrice = false): QueryBuilder
    {
        $query = $this->createQueryBuilder('product')
            ->join('product.category','category');
        if ($search->getRecherche()){
            $query = $query
                ->andWhere('product.name LIKE :recherche')
                ->setParameter('recherche', "%".$search->getRecherche()."%");
        }
        if ($search->getPrixMax()){
            $query = $query
                ->andWhere('product.price < :maxprice')
                ->setParameter('maxprice', $search->getPrixMax());
        }
        if ($search->getPrixMin()){
            $query = $query
                ->andWhere('product.price >= :minprice')
                ->setParameter('minprice', $search->getPrixMin());
        }
        if ($search->getCategories()){
            $query = $query
                ->andWhere('product.category = :category')
                ->setParameter('category', $search->getCategories());
        }
        if ($search->getPromo()){
            $query = $query
                ->andWhere('product.promo = :promo')
                ->setParameter('promo', $search->getPromo());
        }

        return $query;
    }






    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
