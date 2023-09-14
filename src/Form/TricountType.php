<?php

namespace App\Form;

use App\Entity\Tricount;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TricountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('users', EntityType::class, [
                'class' => User::class, // Entité des utilisateurs
                'choice_label' => 'username', // Le champ de l'entité User à afficher
                'multiple' => true, // Permet la sélection multiple
                'expanded' => true, // Affiche les cases à cocher au lieu d'une liste déroulante
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
