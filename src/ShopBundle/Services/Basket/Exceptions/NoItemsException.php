<?php


namespace ShopBundle\Services\Basket\Exceptions;


use \Exception;


class NoItemsException extends Exception
{
    protected $message = 'You have added the maximum stock for this item.';




}
