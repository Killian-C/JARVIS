<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\Shift;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShiftType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recipes', EntityType::class, [
                'class' => Recipe::class,
                'choice_label' => 'title',
                'placeholder' => 'Sélectionner une recette',
                'required' => false,
                'mapped' => false,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('peopleCount')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Shift::class,
        ]);
    }
}
