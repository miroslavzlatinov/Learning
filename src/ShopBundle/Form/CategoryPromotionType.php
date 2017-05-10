<?php

namespace ShopBundle\Form;

use ShopBundle\Entity\Promotion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryPromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('promotion', PromotionType::class, array(
            'data_class' => Promotion::class,
        ))->add('category', EntityType::class,
            ['class' => 'ShopBundle\Entity\Category',
                'choice_label' => 'Category']);

    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            ['data_class' => 'ShopBundle\Entity\Promotion']
        ));
    }

    public function getBlockPrefix()
    {
        return 'shop_bundle_category_promotion';
    }
}
