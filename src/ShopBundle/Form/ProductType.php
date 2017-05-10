<?php

namespace ShopBundle\Form;

use ShopBundle\Entity\Product;
use ShopBundle\Transformers\TagTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('stock', NumberType::class)
            ->add('price', MoneyType::class, ["currency" => 'BGN'])
            ->add('category', EntityType::class, ['class' => 'ShopBundle\Entity\Category', 'choice_label' => 'category'])
            ->add('published', CheckboxType::class)
            ->add('tags', TextType::class)

            ->add('image_form', FileType::class,
                [
                    'data_class' => null,
                    'required' => false
                ]);
        $builder->get('tags')->addModelTransformer(
            new TagTransformer()
        );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Product::class,

            ]
        );
    }

    public function getBlockPrefix()
    {
        return 'shop_bundle_product';
    }
}
