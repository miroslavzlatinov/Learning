<?php

namespace ShopBundle\Repository;

/**
 * CartItemRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CartItemRepository extends \Doctrine\ORM\EntityRepository
{
    public function countCart($identifier)
    {
        $count = $this->createQueryBuilder('ci')
            ->select('COUNT (ci.id)')->where('ci.identity = :ident')
            ->setParameter('ident', $identifier)->getQuery()->getSingleResult();
        return $count;

    }

    public function updateStatus($index, $quantity, $identity)
    {
        $qb = $this->createQueryBuilder('ci')
            ->update()
            ->set('ci.quantity', $quantity)
            ->where('ci.cartIndex = :index')
            ->andWhere('ci.identity = :identity')
            ->setParameter('index', $index)
            ->setParameter('identity', $identity);

        return $qb->getQuery()
            ->getResult();
    }

    public function insertItem($index, $quantity)
    {
        $qb = $this->createQueryBuilder('ci')
            ->getEntityManager();


    }

    public function updateIdentity($ident, $ids)
    {

        $qb = $this->createQueryBuilder('ci');

        $qb->update()
            ->set('ci.identity', ':ident')
            ->where($qb->expr()->in('ci.id', ':ids'))
            ->setParameter(':ident', $ident)
            ->setParameter(':ids', $ids);


        return $qb->getQuery()
            ->execute();

    }


}
