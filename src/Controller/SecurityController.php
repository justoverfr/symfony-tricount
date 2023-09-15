<?php

namespace App\Controller;

use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public function __construct(AuthService $authService)
    {
        $this -> authService = $authService;
    }

    /**
     * Route de connexion
     *
     * @param AuthenticationUtils $authenticationUtils Utilitaire d'authentification
     * @return Response page de connexion
     */
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Redirection si l'utilisateur est déjà connecté
        if ($this->getUser()) {
            return $this->redirectToRoute('app_default');
        }

        // Récupération des informations de connexion
        $loginResponse = $this->authService->login($authenticationUtils);
        $lastUsername = $loginResponse['last_username'];
        $error = $loginResponse['error'];

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * Route de déconnexion
     *
     * @return void
     */
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
