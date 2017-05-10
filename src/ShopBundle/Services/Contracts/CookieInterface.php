<?php

/**
 * Created by PhpStorm.
 * User: mzlatinov
 * Date: 4/17/17
 * Time: 8:02 AM
 */

namespace ShopBundle\Services\Contracts;

interface CookieInterface
{
    public function getCookies($request, $name);

    public function setCookie($value, $name, $request);

    public function createCookieVariable($name, $value);

    public function clearCookies($name);


}