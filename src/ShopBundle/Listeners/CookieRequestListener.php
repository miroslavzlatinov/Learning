<?php
/**
 * Created by PhpStorm.
 * User: mzlatinov
 * Date: 4/22/17
 * Time: 12:33 PM
 */

namespace ShopBundle\Listeners;


use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class CookieRequestListener
{


    protected $container;

    public function __construct(\Symfony\Component\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }


    public function onKernelRequest(GetResponseEvent $event)
    {


        $response = $event->getResponse();
        $request = $event->getRequest();


        if ($request->cookies->get('boiler')) {
            $bsession = $request->cookies->get('boiler');

            $this->container->get('basket')->setcookie($bsession,0);
        }


        return $response;


    }
}