<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthService
{
    public function __construct()
    {
    }

    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Renvoie une réponse contenant le nom de l'utilisateur et l'erreur
        return ['last_username' => $lastUsername, 'error' => $error];
    }

    public function register(User $user,FormInterface $form,UserPasswordHasherInterface $userPasswordHasher,EntityManagerInterface $entityManager): void
    {
        // encode the plain password
        $user->setPassword(
            $userPasswordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            )
        );

        $entityManager->persist($user);
        $entityManager->flush();
        // do anything else you need here, like send an email
    }
}