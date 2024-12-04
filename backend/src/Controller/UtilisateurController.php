<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/utilisateur', name: 'utilisateur_index')]
    public function index(): Response
    {
        // Appelle la méthode existante pour obtenir les utilisateurs.
        $utilisateurs = $this->getUtilisateurs();

        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }

    #[Route('/api/utilisateurs', name: 'api_utilisateurs_list', methods: ['GET'])]
    public function getUtilisateurs(): JsonResponse
    {
        $utilisateurs = $this->entityManager->getRepository(Utilisateur::class)->findAll();
        $data = [];

        foreach ($utilisateurs as $utilisateur) {
            $data[] = [
                'id' => $utilisateur->getId(),
                'nom' => $utilisateur->getNom(),
                'prenom' => $utilisateur->getPrenom(),
                'email' => $utilisateur->getEmail(),
                'roles' => $utilisateur->getRoles(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/utilisateur/create', name: 'utilisateur_create')]
    public function create(Request $request): Response
    {
        // Logique pour créer un utilisateur (par exemple, affichage d'un formulaire)
        return $this->render('utilisateur/create.html.twig', [
            'message' => 'Créer un nouvel utilisateur',
        ]);
    }
}
