<?php
namespace ShopBundle\Services\CookieManager;

use ShopBundle\Services\Contracts\CookieInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Request;

/**
 * Created by PhpStorm.
 * User: mzlatinov
 * Date: 4/22/17
 * Time: 5:20 AM
 */
class CookieManager implements CookieInterface
{
    public function setCookie($value, $name, $request)
    {
        $newestCookie = array(
            0 => $value,
        );

        $unserializedCookies = $this->getCookies($request, $name);
        $unserializedCookies = $newestCookie + $unserializedCookies;
        //$unserializedCookies = array_slice($unserializedCookies, 0 , 5); //only first 5

        $newCookie = $this->createCookieVariable($name, serialize($unserializedCookies));

        $response = new Response();
        $response->headers->setCookie($newCookie);
        $response->send();
    }

    public function getCookies($request, $name)
    {
        $cookies = $request->cookies;
        if ($cookies->get($name)){
            $allCookies = unserialize($cookies->get($name));
        } else {
            $allCookies = [];
        }

        return $allCookies;
    }

    public function createCookieVariable($name, $value)
    {
        $cookieGuest = array(
            'name'  => $name,
            'value' => $value,
            'path' => '/',
            'time'  => time() + 3600 * 24 * 7
        );

        $cookie = new Cookie($cookieGuest['name'], $cookieGuest['value'], $cookieGuest['time'], $cookieGuest['path']);

        return $cookie;
    }

    public function clearCookies($name)
    {
        $response = new Response();
        $response->headers->clearCookie($name);
        $response->send();
    }


}