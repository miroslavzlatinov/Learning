<?php
/**
 * Created by PhpStorm.
 * User: mzlatinov
 * Date: 4/22/17
 * Time: 7:39 AM
 */

namespace ShopBundle\Listeners;


use Symfony\Component\HttpKernel\Event\FilterResponseEvent;


class CookieListener
{
    protected $container;

    public function __construct(\Symfony\Component\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {

        $response = $event->getResponse();
        $request = $event->getRequest();
        $hash = bin2hex(random_bytes(20));



        if (!$request->cookies->get('boiler')) {//

            $this->container->get('cookie.manager')->setCookie("[" . $hash . "]", 'boiler', $request);

        }

//        if ($request->cookies->get('boiler')) {
//            $this->container->get('cookie.manager')->clearCookies('boiler');
//
//            $this->container->get('cookie.manager')->setCookie("[" . $hash . "]", 'boiler', $request);
//            $this->container->get('basket')->setcookie($hash,1);
//
//
//
//        }

//        if ($request->cookies->get('boiler')) {
//            $bsession = $request->cookies->get('boiler');
//            $this->container->get('basket')->setcookie($bsession,0);
//        }

        return $response;
    }


}