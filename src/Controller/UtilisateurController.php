<?php

// src/Controller/UtilisateurController.php
namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/utilisateur', name: 'utilisateur_index')]
    public function index(): Response
    {
        $utilisateurs = $this->entityManager->getRepository(Utilisateur::class)->findAll();
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }

    #[Route('/utilisateur/create', name: 'utilisateur_create')]
    public function create(Request $request): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($utilisateur);
            $this->entityManager->flush();

            return $this->redirectToRoute('utilisateur_index');
        }

        return $this->render('utilisateur/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/utilisateur/{id}', name: 'utilisateur_show')]
    public function show(int $id): Response
    {
        $utilisateur = $this->entityManager->getRepository(Utilisateur::class)->find($id);
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/utilisateur/{id}/edit', name: 'utilisateur_edit')]
    public function edit(Request $request, int $id): Response
    {
        $utilisateur = $this->entityManager->getRepository(Utilisateur::class)->find($id);
        $form = $this->createForm(UtilisateurType::class, $utilisateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('utilisateur_index');
        }

        return $this->render('utilisateur/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}


?>