<?php


namespace ShopBundle\Listeners;

use Symfony\Component\EventDispatcher\Event;

class EmptyBasket
{


    public function onOrderAction(Event $event)
    {

        $event->basket->clear();


    }
}


