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

    #[Route('/api/utilisateurs', name: 'api_utilisateurs_create', methods: ['POST'])]
    public function createUtilisateur(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validation de base des données reçues
        if (empty($data['nom']) || empty($data['prenom']) || empty($data['email']) || empty($data['password']) || empty($data['roles'])) {
            return new JsonResponse(['error' => 'Invalid data'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Création d'un nouvel utilisateur
        $utilisateur = new Utilisateur();
        $utilisateur->setNom($data['nom']);
        $utilisateur->setPrenom($data['prenom']);
        $utilisateur->setEmail($data['email']);
        
        // Hachage du mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword($utilisateur, $data['password']);
        $utilisateur->setPassword($hashedPassword);

        // Définition des rôles
        $utilisateur->setRoles($data['roles']);

        // Sauvegarde dans la base de données
        $this->entityManager->persist($utilisateur);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Utilisateur créé avec succès !'], JsonResponse::HTTP_CREATED);
    }
}
