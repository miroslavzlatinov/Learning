<?php
/**
 * Created by PhpStorm.
 * User: mzlatinov
 * Date: 4/22/17
 * Time: 6:05 PM
 */

namespace ShopBundle\Listeners;

use Doctrine\ORM\EntityManager;
use ShopBundle\Entity\Payment;
use Symfony\Component\EventDispatcher\Event;

class FailedPayment
{

    private $em;


    public function __construct(EntityManager $em)
    {
        $this->em = $em;

    }


    public function onOrderAction(Event $event)
    {

        $payment = new Payment();
        $oId = $event->order;
        $payment->setOrderId($oId);
        $payment->setTransactionId("nocache");
        $payment->setFailed(true);
        $this->em->persist($payment);
        $this->em->flush();;


    }
}


