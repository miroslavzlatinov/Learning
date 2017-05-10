<?php
/**
 * Created by PhpStorm.
 * User: mzlatinov
 * Date: 4/29/17
 * Time: 10:53 AM
 */

namespace ShopBundle\Transformers;


use Symfony\Component\Form\DataTransformerInterface;

class TagTransformer implements DataTransformerInterface
{


    public function transform($tagAsArray)
    {
        if (empty($tagAsArray)) {
            return "";
        }

        return implode(',', $tagAsArray);
    }


    public function reverseTransform($tagAsArray)
    {

        if (empty($tagAsArray)) {
            return "";
        }
        return explode(',', $tagAsArray);
    }
}