<?php

namespace App\Form;

use App\Entity\ListItem;
use App\Entity\ShopPlace;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('checked', CheckboxType::class, [
                'label'    => false,
                'required' => false,
            ])
            ->add('content', TextareaType::class, [
                'label' => false,
            ])
            ->add('quantity', NumberType::class, [
                'label' => false,
                'attr'  => [
                    'min'   => 1,
                    'step'  => 0.1
                ]
            ])
            ->add('shopPlace', EntityType::class, [
                'class'        => ShopPlace::class,
                'choice_label' => 'name',
                'placeholder'  => "Lieu d'achat",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ListItem::class,
        ]);
    }
}