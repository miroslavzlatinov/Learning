<?php
/**
 * Created by PhpStorm.
 * User: mzlatinov
 * Date: 4/22/17
 * Time: 5:32 PM
 */

namespace ShopBundle\Listeners;


use Symfony\Component\EventDispatcher\Event;

class AcmeListener
{

    /**
     * AcmeListener constructor.
     */
    public function __construct()
    {
    }

    public function onFooAction(Event $event)
    {
        $event->basket->clear();;
    }
}