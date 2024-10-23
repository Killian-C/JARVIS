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
    private RecipeToTitleTransformer $recipeToTitleTransformer;
    public function __construct(RecipeToTitleTransformer $recipeToTitleTransformer)
    {
        $this->recipeToTitleTransformer = $recipeToTitleTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Dish $dish */
        $dish = $builder->getData();

        $peopleCountTypeOptions = [ 'label' => 'Nombre de personnes' ];
        if (array_key_exists(MenuType::OPT_KEY_MODE, $options) && $options[MenuType::OPT_KEY_MODE] === MenuType::OPT_ARG_MODE_NEW) {
            $peopleCountTypeOptions['data'] = self::DEFAULT_PEOPLE_COUNT;
        }

        $builder
            ->add('recipe', TextType::class, [
//                TODO traiter le label, etc. on a un vieux point avec le mot recipe ici
//                'class'        => Recipe::class,
//                'choice_label' => 'title',
//                'placeholder'  => 'Sélectionner une recette'
                'attr' => [ 'list' => 'recipeList' ]
            ])
            ->add('peopleCount', IntegerType::class, $peopleCountTypeOptions)
        ;

        $builder
            ->get('recipe')
            ->addModelTransformer($this->recipeToTitleTransformer)
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
