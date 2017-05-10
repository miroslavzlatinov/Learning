<?php
/**
 * Created by PhpStorm.
 * User: mzlatinov
 * Date: 4/22/17
 * Time: 6:05 PM
 */

namespace ShopBundle\Listeners;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\Event;

class UpdateStock
{
    private $em;


    public function __construct(EntityManager $em)
    {
        $this->em = $em;

    }


    public function onOrderAction(Event $event)
    {

        foreach ($event->basket->all() as $p) {
            $stock = $p->quantity;
            $id = $p->getId();


            $this->em->getRepository('ShopBundle:Product')
                ->updateStock($stock, $id);


        }
    }


}