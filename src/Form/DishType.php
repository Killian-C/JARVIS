<?php

namespace App\Form;

use App\Entity\Dish;
use App\Entity\Recipe;
use App\Form\DataTransformer\RecipeToTitleTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DishType extends AbstractType
{
    public const DEFAULT_PEOPLE_COUNT = 2;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $peopleCountTypeOptions = [ 'label' => 'Nombre de personnes' ];
        if (array_key_exists(MenuType::OPT_KEY_MODE, $options) && $options[MenuType::OPT_KEY_MODE] === MenuType::OPT_ARG_MODE_NEW) {
            $peopleCountTypeOptions['data'] = self::DEFAULT_PEOPLE_COUNT;
        }

        $builder
            ->add('recipe', EntityType::class, [
                'class' => Recipe::class,
                'choice_label' => 'title',
                'placeholder'  => 'Choose Recipe',
            ])
            ->add('peopleCount', IntegerType::class, $peopleCountTypeOptions)
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'            => Dish::class,
            MenuType::OPT_KEY_MODE  => MenuType::OPT_ARG_MODE_EDIT,
        ]);
    }
}
