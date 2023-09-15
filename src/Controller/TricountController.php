<?php

namespace App\Controller;

use App\Entity\Tricount;
use App\Form\TricountType;
use App\Repository\TricountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tricount')]
class TricountController extends AbstractController
{
    /**
     * Liste des tricounts
     *
     * @param TricountRepository $tricountRepository Utilitaire de gestion des tricounts
     * @return Response page de la liste des tricounts
     */
    #[Route('/', name: 'app_tricount_index', methods: ['GET'])]
    public function index(TricountRepository $tricountRepository): Response
    {
        return $this->render('tricount/index.html.twig', [
            'tricounts' => $tricountRepository->findAll(),
        ]);
    }

    /**
     * Page de création d'un tricount
     *
     * @param Request $request Informations de la requête
     * @param EntityManagerInterface $entityManager Utilitaire de gestion des entités
     * @return Response page de création d'un tricount
     */
    #[Route('/new', name: 'app_tricount_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tricount = new Tricount();
        $form = $this->createForm(TricountType::class, $tricount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tricount);
            $entityManager->flush();

            return $this->redirectToRoute('app_tricount_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tricount/new.html.twig', [
            'tricount' => $tricount,
            'form' => $form,
        ]);
    }

    /**
     * Page d'affichage d'un tricount en fonction de son id
     *
     * @param Tricount $tricount Tricount à afficher
     * @return Response page d'affichage d'un tricount
     */
    #[Route('/{id}', name: 'app_tricount_show', methods: ['GET'])]
    public function show(Tricount $tricount): Response
    {
        return $this->render('tricount/show.html.twig', [
            'tricount' => $tricount,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tricount_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tricount $tricount, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TricountType::class, $tricount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tricount_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tricount/edit.html.twig', [
            'tricount' => $tricount,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tricount_delete', methods: ['POST'])]
    public function delete(Request $request, Tricount $tricount, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tricount->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tricount);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tricount_index', [], Response::HTTP_SEE_OTHER);
    }
}
