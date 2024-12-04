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

    #[Route('/utilisateur', name: 'utilisateur_index')]
    public function index(): Response
    {
        // Récupère la liste des utilisateurs depuis la base de données
        $utilisateurs = $this->entityManager->getRepository(Utilisateur::class)->findAll();

        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }
    #[Route('/utilisateur/create', name: 'utilisateur_create')]
    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();
    
            $utilisateur = new Utilisateur();
            $utilisateur->setNom($data['nom']);
            $utilisateur->setPrenom($data['prenom']);
            $utilisateur->setEmail($data['email']);
            $utilisateur->setPassword(password_hash($data['password'], PASSWORD_BCRYPT)); // Hash du mot de passe
            $utilisateur->setRole((int)$data['role']);
    
            $this->entityManager->persist($utilisateur);
            $this->entityManager->flush();
    
            return $this->redirectToRoute('utilisateur_index');
        }
    
        return $this->render('utilisateur/create.html.twig');
    }     
}
