<?php
/**
 * Created by PhpStorm.
 * User: mzlatinov
 * Date: 4/28/17
 * Time: 4:17 PM
 */
namespace ShopBundle\Services\Basket\Exceptions;


use \Exception;


class NotCache extends Exception
{
    protected $message = 'You don\'t have enough money.';




}