<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UtilisateurController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Route pour afficher la liste des utilisateurs
    #[Route('/utilisateur', name: 'utilisateur_show')]
    public function index(): Response
    {
        // Récupérer tous les utilisateurs
        $utilisateurs = $this->entityManager->getRepository(Utilisateur::class)->findAll();

        // Passer la liste des utilisateurs à la vue
        return $this->render('utilisateur/show.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }

    // Route pour afficher un utilisateur spécifique
    #[Route('/utilisateur/{id}', name: 'utilisateur_show_one')]
    public function show(int $id): Response
    {
        // Récupérer l'utilisateur par son ID
        $utilisateur = $this->entityManager->getRepository(Utilisateur::class)->find($id);

        // Si l'utilisateur n'existe pas, renvoyer une erreur
        if (!$utilisateur) {
            throw $this->createNotFoundException('No user found for id ' . $id);
        }

        // Passer l'utilisateur à la vue pour affichage
        return $this->render('utilisateur/showOne.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    // Route pour créer un nouvel utilisateur
    #[Route('/utilisateur/create', name: 'utilisateur_create')]
    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            $utilisateur = new Utilisateur();
            $utilisateur->setNom($data['nom']);
            $utilisateur->setPrenom($data['prenom']);
            $utilisateur->setEmail($data['email']);
            $utilisateur->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));
            $utilisateur->setRole((int)$data['role']);

            $this->entityManager->persist($utilisateur);
            $this->entityManager->flush();

            return $this->redirectToRoute('utilisateur_show');
        }

        return $this->render('utilisateur/create.html.twig');
    }

    // Route pour éditer un utilisateur
    #[Route('/utilisateur/{id}/edit', name: 'utilisateur_edit')]
    public function edit(int $id, Request $request): Response
    {
        // Récupérer l'utilisateur par son ID
        $utilisateur = $this->entityManager->getRepository(Utilisateur::class)->find($id);

        if (!$utilisateur) {
            throw $this->createNotFoundException('No user found for id ' . $id);
        }

        // Si le formulaire est soumis, mettre à jour les données
        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            $utilisateur->setNom($data['nom']);
            $utilisateur->setPrenom($data['prenom']);
            $utilisateur->setEmail($data['email']);
            $utilisateur->setRole((int)$data['role']);

            // Si un nouveau mot de passe est fourni, le mettre à jour
            if (!empty($data['password'])) {
                $utilisateur->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));
            }

            $this->entityManager->flush();

            return $this->redirectToRoute('utilisateur_show');
        }

        // Afficher le formulaire de modification avec les données actuelles de l'utilisateur
        return $this->render('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    // Route pour supprimer un utilisateur
    #[Route('/utilisateur/{id}/delete', name: 'utilisateur_delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        // Récupérer l'utilisateur par son ID
        $utilisateur = $this->entityManager->getRepository(Utilisateur::class)->find($id);

        // Si l'utilisateur n'existe pas, renvoyer une erreur
        if (!$utilisateur) {
            throw $this->createNotFoundException('No user found for id ' . $id);
        }

        // Supprimer l'utilisateur
        $this->entityManager->remove($utilisateur);
        $this->entityManager->flush();

        // Retourner une réponse JSON avec un statut de succès
        return $this->json(['status' => 'success']);
    }
}