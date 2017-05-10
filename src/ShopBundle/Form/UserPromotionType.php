<?php

namespace ShopBundle\Form;

use ShopBundle\Entity\Promotion;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserPromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('promotion', PromotionType::class, array(
            'data_class' => Promotion::class,
        ))->add('item',ChoiceType::class, array(
            'choices'  => array(
                'user' => 'user',


            )))
        ->add('value1',ChoiceType::class, array(
            'choices'  => array(
                'CreateDate' => 'createdate',
                'Cache' => 'cache',

            ))) ->add('rule',ChoiceType::class, array(
                'choices'  => array(
                    '=' => '=',
                    '>' => '>',
                    '<' => '<',
                    '>=' => '>=',
                    '<=' => '<=',

                )))
            ->add('value2',TextType::class,['attr'=>['placeholder' => 'date YYYY:mm:dd or Number']])

            ->add('logic',ChoiceType::class, array(
                'choices'  => array(
                    'and' => 'and',
                    'or' => 'or',

                )))->add('value3',ChoiceType::class, array(
                'choices'  => array(
                    'CreateDate' => 'createdate',
                    'Cache' => 'cache',

                )))->add('rule2',ChoiceType::class, array(
                'choices'  => array(
                    '=' => '=',
                    '>' => '>',
                    '<' => '<',
                    '>=' => '>=',
                    '<=' => '<=',

                ))) ->add('value4',TextType::class,['attr'=>['placeholder' => 'date YYYY:mm:dd or Number']])


            ->add('userdefined',HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            ['data_class' => 'ShopBundle\Entity\Promotion']
        ));


    }

    public function getBlockPrefix()
    {
        return 'shop_bundle_user_promotion_type';
    }
}
/**
 * user , product
 *  createdate,cache , stock
 *  =,>,<,<= ,>=
 *
 */