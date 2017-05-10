<?php
/**
 * Created by PhpStorm.
 * User: mzlatinov
 * Date: 4/21/17
 * Time: 8:52 AM
 */

namespace ShopBundle\Services\Basket;


use Doctrine\ORM\EntityManager;
use ShopBundle\Entity\CartItem;
use ShopBundle\Services\Contracts\StorageInterface;


class BasketDbStorage implements StorageInterface

{


    protected $bucket;
    protected $em;
    protected $table;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        //$this->table = $table;

    }


    public function get($index)
    {

        $item = $this->em->getRepository('ShopBundle:CartItem')->findBy(['cartIndex' => $index]);
        if ($item) {
            return $item;
        }
    }

    public function set($index, $value, $ident)
    {


        $em = $this->em->getRepository('ShopBundle:CartItem')
            ->createQueryBuilder('ci')->getEntityManager();
        $item = new CartItem();
        $item->setCartIndex($index->getId());
        $item->setProductId($index->getId());
        $item->setIdentity($ident);
        $item->setQuantity($value);
        $em->persist($item);
        $em->flush();


    }

    public function update($index, $value, $ident)
    {

        $quantity = (string)$value['quantity'];

        $this->em->getRepository('ShopBundle:CartItem')
            ->updateStatus($index, $quantity, $ident);

    }


    public function all($identity)
    {
        $item = $this->em->getRepository('ShopBundle:CartItem')
            ->findBy(['identity' => $identity]);

        return $item;
    }

    public function exists($index, $identifier)
    {
        $item = $this->em->getRepository('ShopBundle:CartItem')
            ->findBy(['cartIndex' => $index, 'identity' => $identifier]);

        return $item;
    }

    public function remove($index, $identifier)
    {
        $item = $this->em->getRepository('ShopBundle:CartItem')->findOneBy(['cartIndex' => $index, 'identity' => $identifier]);
        $em = $this->em->getRepository('ShopBundle:CartItem')
            ->createQueryBuilder('ci')->getEntityManager();
        $em->remove($item);
        $em->flush();
    }

    public function clear($identifier)
    {
        $items = $this->em->getRepository('ShopBundle:CartItem')->findBy(['identity' => $identifier]);
        $this->deleteEntities($this->em, $items);

        $this->em->flush($items);
    }

    protected function deleteEntities($em, $entities)
    {

        foreach ($entities as $entity) {
            $em->remove($entity);
        }
    }

    public function count($identifier)
    {

        $items = $this->em->getRepository('ShopBundle:CartItem')
            ->countCart($identifier);
        if ($items) {
            return $items[1];
        }

    }

    public function updateIdentity($identifier, $items)
    {
        $items = array_map(function ($in) {
            return [$in->getId()];
        }, $items);

        //$title = array_column($a, $id)[0];;

        $em = $this->em->getRepository('ShopBundle:CartItem')
            ->updateIdentity($identifier, $items[0]);

        // $em->persist($items[0]->setIdentit);

    }


}