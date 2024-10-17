<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\RecipeType as Type;
use App\Entity\Season;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('recipeType', EntityType::class, [
                'class'        => Type::class,
                'choice_label' => 'name',
                'placeholder'  => 'Sélectionner le type de recette'
            ])
            ->add('season', EntityType::class, [
                'class'        => Season::class,
                'choice_label' => 'name',
                'placeholder'  => 'Sélectionner la saison'
            ])
            ->add('ingredients',
                CollectionType::class,
                [
                    'entry_type' => IngredientType::class,
                    'allow_add'  => true
                ],
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
