<?php
/**
 * Created by PhpStorm.
 * User: mzlatinov
 * Date: 4/17/17
 * Time: 8:02 AM
 */

namespace ShopBundle\Services\Contracts;

interface StorageInterface
{
    public function get($index);

    public function set($index, $value, $ident);

    public function all($identity);

    public function exists($index, $identifier);

    public function remove($index, $identifier);

    public function clear($identifier);

    public function count($identifier);

    public function update($index, $value, $ident);

    public function updateIdentity($ident,$items);
}