<?php
/**
 * Created by PhpStorm.
 * User: mzlatinov
 * Date: 4/22/17
 * Time: 6:05 PM
 */

namespace ShopBundle\Listeners;

use Symfony\Component\EventDispatcher\Event;

class MarkOrderPaid
{


    public function onOrderAction(Event $event)
    {

        $event->order->setPaid(true);


    }
}


