<?php

namespace App\Form;

use App\Entity\Tricount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TricountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('addUserInput', TextType::class, [
                'mapped' => false, // Indique que ce n'est pas un attribut de l'entité
                'label' => 'Enter an username',
            ])
            ->add('addUserButton', ButtonType::class, [
                'label' => 'Add user to the tricount',
                'attr' => [
                    'class' => 'add-user-btn',
                ],
            ])
            ->add('addedUsers', HiddenType::class, [
                'mapped' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tricount::class,
        ]);
    }
}
