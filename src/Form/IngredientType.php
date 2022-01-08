<?php

namespace App\Form;

use App\Entity\Ingredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\DataTransformer\AlimentToNameTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class IngredientType extends AbstractType
{

    private  $transformer;

    public function __construct(AlimentToNameTransformer $alimentTransformer)
    {
        $this->transformer = $alimentTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('aliment', TextType::class,
                [
                    'attr' => [ 'list' => 'alimentList' ]
                ]
            )
            ->add('quantity')
        ;

        $builder
            ->get('aliment')
            ->addModelTransformer($this->transformer)
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ingredient::class,
        ]);
    }
}
