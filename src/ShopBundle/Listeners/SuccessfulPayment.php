<?php


namespace ShopBundle\Listeners;

use Doctrine\ORM\EntityManager;
use ShopBundle\Entity\Payment;
use Symfony\Component\EventDispatcher\Event;

class SuccessfulPayment
{


    private $em;
    private $user;

    public function __construct(EntityManager $em, $user)
    {
        $this->em = $em;
        $this->user = $user;
    }


    public function onOrderAction(Event $event)
    {
//        $securityContext = $this->get('security.authorization_checker');

        $id = "";
//        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {

//            $user = $this->getUser();
//            $id = $user->getId();

//        }
        $spent = $event->basket->subTotal() + 5;
        $cache = $this->em->getRepository('ShopBundle:User')
            ->createQueryBuilder('c')
            ->where('c.id = :id')
            ->select('c.cache')
            ->setParameter('id', $this->user)
            ->getQuery()->getScalarResult();
        $in = array_map(function ($in) {
            return $in['cache'];
        }, $cache);
        $before = $in[0];

        $before -= $spent;

        $qbupdate = $this->em->getRepository('ShopBundle:User')
            ->createQueryBuilder('u')
            ->update()
            ->set('u.cache', ':cahe')
            ->where('u.id = :id')
            ->setParameter('id', $this->user)
            ->setParameter('cahe', $before)->getQuery()->execute();

        $payment = new Payment();

        $payment->setOrderId($event->order);
        $payment->setTransactionId("ima");
        $payment->setFailed(false);
        $this->em->persist($payment);
        $this->em->flush();


    }
}


