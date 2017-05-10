<?php
/**
 * Created by PhpStorm.
 * User: mzlatinov
 * Date: 4/22/17
 * Time: 1:01 PM
 */

namespace ShopBundle\Events;


use ShopBundle\Entity\Orders;
use ShopBundle\Services\Basket\Basket;
use Symfony\Component\EventDispatcher\Event;

class OrderWasCreated extends Event
{
    const NAME = 'order.placed';


    public $order;
    public $basket;

    public function __construct(Orders $order, Basket $basket)
    {


        $this->order = $order;
        $this->basket = $basket;
    }
}
