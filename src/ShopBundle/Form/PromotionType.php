<?php

namespace ShopBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionType extends AbstractType
{


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',TextType::class)
            ->add('dateFrom',DateType::class)
            ->add('dateTo' ,DateType::class)
            ->add('discount',NumberType::class,["label"=>"Percent"]);
    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'inherit_data' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'shopbundle_promotion';
    }


    /* public function finishView(FormView $view, FormInterface $form, array $options)
     {
         $new_choice = new ChoiceView(array(), '-1', 'All'); // <- new option

         // $view->children["category"]->vars["choices"][1] = $new_choice;//<- adding the new option
         array_unshift($view->children["category"]->vars["choices"],$new_choice);
         array_unshift($view->children["product"]->vars["choices"],$new_choice);

     }*/

}
