<?php

namespace ShopBundle\Repository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends \Doctrine\ORM\EntityRepository
{
    /*
        public function findAll()
        {
            $products =  $this->createQueryBuilder('p');
            $products->where('p.category IS NOT NULL');
            return $products->getQuery()->getResult();

        }*/

    public function ProductsUserAll()
    {


        return $qb2 = $this->createQueryBuilder('p')
            ->leftJoin('p.user', 'u')->select('p', 'u.name')
            ->getQuery()
            ->getScalarResult();


    }

    public function updateStock($stock, $id)
    {
        $aval = $this->createQueryBuilder('p')->select('p.stock')
            ->where('p.id = :id')->setParameter(':id', $id)
            ->getQuery()->getScalarResult();

        $in = array_map(function ($in) {
            return $in['stock'];
        }, $aval);
        $stockin = $in[0];
        $stockin -= $stock;
        $qb = $this->createQueryBuilder('p')
            ->update()
            ->set('p.stock', ':stock')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->setParameter('stock', $stockin);

        return $qb->getQuery()
            ->execute();
    }


}

