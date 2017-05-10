<?php
/**
 * Created by PhpStorm.
 * User: mzlatinov
 * Date: 4/15/17
 * Time: 1:48 PM
 */

namespace ShopBundle\Services\Price;


use ShopBundle\Entity\Product;

class Engine
{
    private $language;
    private $discountRules = array();

    /**
     * Creates a new pricing engine.
     *
     * @param Language $language Our custom language
     */
    public function __construct(Language $language)
    {
        $this->language = $language;
    }

    /**
     * Adds a discount rule.
     *
     * @param string $expression The discount expression
     */
    public function addDiscountRule($expression)
    {

        $this->discountRules[] = $expression;
    }

    public  function isRule()
    {

       return isset($this->discountRules[0]);

    }
    public function clearRules(){


        if( isset($this->discountRules))
        {
            unset($this->discountRules);
            $this->discountRules = array();
        }


    }


    /**
     * Calculates the product price.
     *
     * @param Product $product The product
     *
     * @return array
     */
    public function calculatePrice(Product $product)
    {

        $discounted = [];

        foreach ($this->discountRules as $prmotion) {

            foreach ($prmotion as $key=> $discountRule) {


                $price = $product->getPrice();
                $price -= $price * $this->language->evaluate($discountRule, array('product' => $product));
                $discounted[$key] = $price;
            }
        }

        if (is_array($discounted)) {
            arsort($discounted);

           $key =  array_keys($discounted);
           $key = end($key);

           $return =  [$key => array_pop($discounted)];

           return $return;
        }

        return $discounted;
    }

}