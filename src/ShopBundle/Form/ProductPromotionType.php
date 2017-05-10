<?php

namespace ShopBundle\Form;

use ShopBundle\Entity\Promotion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductPromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('promotion', PromotionType::class, array(
            'data_class' => Promotion::class,
        ))->add('product', EntityType::class,
            ['class' => 'ShopBundle\Entity\Product',
                'choice_label' => 'product']);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            ['data_class' => 'ShopBundle\Entity\Promotion']
        ));

    }

    public function getBlockPrefix()
    {
        return 'shop_bundle_product_promotion';
    }
}
