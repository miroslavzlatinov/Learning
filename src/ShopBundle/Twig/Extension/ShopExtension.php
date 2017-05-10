<?php

namespace ShopBundle\Twig\Extension;

class ShopExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'shop';
    }


    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('cast_to_array', array($this, 'casToArray')),
            new \Twig_SimpleFilter('cast_to_asoc', array($this, 'casToAsoc')),
            new \Twig_SimpleFilter('is_array', array($this, 'isArray')),
        );
    }


    public function casToArray($stdClassObject)
    {
        $response = array();
        foreach ($stdClassObject as $key => $value) {
            $response[] = array($key, $value);
        }
        return $response;

    }

    public function casToAsoc($stdClassObject)
    {
        $response = array();
        foreach ($stdClassObject as $key => $value) {
            $response[] = $value;
        }
        return $response;

    }

    public function isArray($value)
    {
        return is_array($value) ? true : false;


    }


}
