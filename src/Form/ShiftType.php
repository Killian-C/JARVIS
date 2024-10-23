<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\Shift;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShiftType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identifier', HiddenType::class)
            ->add('dishes', CollectionType::class, [
                'entry_type' => DishType::class,
                'allow_add'  => true,
                'entry_options' => [MenuType::OPT_KEY_MODE => $options[MenuType::OPT_KEY_MODE]]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'           => Shift::class,
            MenuType::OPT_KEY_MODE => MenuType::OPT_ARG_MODE_EDIT
        ]);
    }
}
