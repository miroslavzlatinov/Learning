<?php
/**
 * Created by PhpStorm.
 * User: mzlatinov
 * Date: 4/26/17
 * Time: 5:34 AM
 */

namespace ShopBundle\Services\Price;


use Doctrine\ORM\EntityManagerInterface;
use ShopBundle\Entity\Product;


class Calculator
{

    protected $calculator;
    protected $em;
    protected $promotions;

    /**
     * Calculator constructor.
     */
    public function __construct(Engine $calculator, EntityManagerInterface $em)
    {
        $this->calculator = $calculator;
        $this->em = $em;
        $this->promotions = self::Promotions();

    }

    /**
     * @param Product $product
     *
     *
     */

    public function calculate(Product $product)
    {


        return $this->calc($product);


    }


    public function getOfferName($id)
    {

        $array = array_map(function ($in) {
            return [$in->getId() => $in->getName()];
        }, $this->promotions);

        $return = array_column($array, $id)[0];
        return $return;

    }

    protected function calc($product)
    {
        //dump($this->promotions);
        $this->calculator->clearRules();
        foreach ($this->promotions as $promotion) {

            if (!is_null($promotion->getProduct())) {


                if ($promotion->getProduct()->getId() == $product->getId()) {

                    $this->calculator->addDiscountRule([$promotion->getId() => $promotion->getRule()]);

                }
            }

            if (!is_null($promotion->getCategory())) {
                if ($promotion->getCategory()->getId() == $product->getCategory()->getId()) {
                    $this->calculator->addDiscountRule([$promotion->getId() => $promotion->getRule()]);


                }

            }

        }


        return $this->calculator->calculatePrice($product);


    }

    protected function Promotions()
    {

        $em = $this->em->createQueryBuilder()
            ->getEntityManager();
        $promotions = $em->getRepository('ShopBundle:Promotion')
            ->findActivePromotions();
        return $promotions;


    }


}