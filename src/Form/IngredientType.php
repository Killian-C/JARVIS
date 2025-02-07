<?php

namespace App\Form;

use App\Entity\Aliment;
use App\Entity\Ingredient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\DataTransformer\AlimentToNameTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class IngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('aliment', EntityType::class,[
                'class'        => Aliment::class,
                'choice_label' => 'prettyName',
                'placeholder'  => 'Choose Aliment',
            ])
            ->add('quantity')
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ingredient::class,
        ]);
    }
}
