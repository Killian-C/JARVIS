<?php

namespace App\Form;

use App\Entity\Aliment;
use App\Entity\ShopPlace;
use App\Entity\Unit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlimentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('category', null, [
                'choice_label' => 'name',
                'multiple'     => false,
                'expanded'     => false,
            ])
            ->add('unit', EntityType::class, [
                'class'        => Unit::class,
                'choice_label' => 'name',
                'placeholder'  => 'Sélectionner l\'unité de mesure',
            ])
            ->add('shopPlace', EntityType::class, [
                'class'        => ShopPlace::class,
                'choice_label' => 'name',
                'placeholder'  => 'Sélectionner un lieu d\'achat',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Aliment::class,
        ]);
    }
}
