<?php
/**
 * Created by PhpStorm.
 * User: mzlatinov
 * Date: 4/17/17
 * Time: 9:33 AM
 */

namespace ShopBundle\Services\Basket;


use Doctrine\ORM\EntityManager;

use ShopBundle\Entity\Product;
use ShopBundle\Entity\Promotion;
use ShopBundle\Services\Basket\Exceptions\NoItemsException;
use ShopBundle\Services\Contracts\StorageInterface;



class Basket
{

    protected $storage;
    protected $em;
    protected $identifier;
    protected $countainer;

    public function __construct(StorageInterface $storage, EntityManager $em , \Symfony\Component\DependencyInjection\Container $container)
    {


        $this->storage = $storage;

        $this->countainer = $container;

        $this->doctrine = $em;


    }

    public function add(Product $product, $quantity)
    {


        if ($this->has($product)) {

            $quantity = $this->get($product, $this->identifier)[0]->getQuantity() + $quantity;

            $this->update($product, $quantity);
        } else {
            $this->storage->set($product, $quantity, $this->identifier);
        }
    }


    public function update(Product $product, $quantity)
    {

//        if (!$this->doctrine->getRepository(Product::class)->find($product->hasStock($quantity))) {
        if (!$product->hasStock($quantity)) {
            throw new NoItemsException();
        }

        if ((int)$quantity === 0) {

            $this->remove($product);
            return;
        }
        $this->storage->update($product->getId(), [
            'product_id' => (int)$product->getId(),
            'quantity' => (int)$quantity,
        ], $this->identifier);
    }

    public function remove(Product $product)
    {
        $this->storage->remove($product->getId(), $this->identifier);
    }

    public function has(Product $product)
    {
        return $this->storage->exists($product->getId(), $this->identifier);
    }

    public function get(Product $product)
    {
        return $this->storage->get($product->getId());
    }

    public function clear()
    {
        return $this->storage->clear($this->identifier);
    }

    protected function getPromotion($item)
    {
        //$this->doctrine->getRepository(Product::class)->findOneBy()
        $price = $this->countainer->get('offer.calculator')
            ->calculate($item);
        $price = array_pop($price);
        return $price;
    }

    public function all()
    {
        $ids = [];
        $items = [];
        foreach ($this->storage->all($this->identifier) as $product) {

            $ids[] = $product->getProductId();
        }


        $products = $this->doctrine->getRepository(Product::class)
            ->findBy(['id' => $ids]);

        foreach ($products as $product) {

            $product->quantity = $this->get($product)[0]->getQuantity();

            $items[] = $product;
        }
        return $items;
    }

    public function itemCount()
    {
        return $this->storage->count($this->identifier);


    }


    public function subTotal()
    {
        $total = 0;
        foreach ($this->all() as $item) {

            if ($item->outOfStock()) {
                continue;
            }; if($this->getPromotion($item))
            {
                $total += ($this->getPromotion($item) * $item->quantity);
            }else{
                $total += ($item->getPrice() * $item->quantity);
            }

        }
        return $total;
    }

    public function refresh()
    {
        foreach ($this->all() as $item) {
            if (!$item->hasStock($item->quantity)) {
                $this->update($item, $item->stock);

            }
        }
    }

    public function setcookie($cookie, $direction)
    {
//        $identity = "";
//        if ($direction == 0) {
            $re = '/([[])(\w+)([\]])/';
            preg_match_all($re, $cookie, $matches, PREG_SET_ORDER, 2);
            $identity = $matches[0][2];
            //  dump($identity);
//        } else {
//            $identity = $cookie;
//        }

//        $items = $this->doctrine->getRepository(CartItem::class)
//            ->findBy(['identity' => $identity]);
//        try {
//            if ($items) {
//                $this->storage->updateIdentity($identity, $items);
//            }
//        } catch (Exception $e) {
//            exit;
//        };

        $this->identifier = $identity;


    }

}