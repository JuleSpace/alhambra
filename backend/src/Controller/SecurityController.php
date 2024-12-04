<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\LogicException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/register', name: 'register')]
    public function register(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            // Vérification des champs obligatoires
            if (empty($data['nom']) || empty($data['prenom']) || empty($data['email']) || empty($data['password'])) {
                return $this->render('security/register.html.twig', [
                    'error' => 'Tous les champs sont obligatoires.',
                ]);
            }

            // Création de l'entité Utilisateur
            $utilisateur = new Utilisateur();
            $utilisateur->setNom($data['nom']);
            $utilisateur->setPrenom($data['prenom']);
            $utilisateur->setEmail($data['email']);

            // Hash du mot de passe avec password_hash() et PASSWORD_BCRYPT
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
            $utilisateur->setPassword($hashedPassword);

            // Définir un rôle par défaut (ROLE_USER)
            $utilisateur->setRoles(['ROLE_USER']); 

            // Persister l'utilisateur dans la base de données
            $this->entityManager->persist($utilisateur);
            $this->entityManager->flush();

            // Redirection vers la page de connexion après l'inscription
            return $this->redirectToRoute('login');
        }

        return $this->render('security/register.html.twig');
    }

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si l'utilisateur est déjà connecté, redirigez-le vers la page d'accueil
        if ($this->getUser()) {
            return $this->redirectToRoute('utilisateur_index');
        }

        // Récupère les erreurs de connexion
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
