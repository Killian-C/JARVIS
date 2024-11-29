<?php

namespace App\Form;

use App\Entity\Menu;
use App\Entity\Shift;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    public const OPT_KEY_MODE = 'mode';
    public const OPT_ARG_MODE_NEW = 'new';
    public const OPT_ARG_MODE_EDIT = 'edit';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startedAt', DateType::class, [
                'widget' => 'single_text',
                'label'  => 'Débute le'
            ])
            ->add('finishedAt', DateType::class, [
                'widget' => 'single_text',
                'label'  => 'Fini le'
            ])
            ->add('shifts', CollectionType::class, [
                'entry_type'    => ShiftType::class,
                'allow_add'     => true,
                'entry_options' => [self::OPT_KEY_MODE => $options[self::OPT_KEY_MODE]],
                'label'         => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'       => Menu::class,
            self::OPT_KEY_MODE => self::OPT_ARG_MODE_EDIT
        ]);
    }
}
