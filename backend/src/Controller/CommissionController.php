<?php

namespace App\Controller;

use App\Entity\Commission;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Entity\LinkCommUser;

class CommissionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Route pour afficher la page d'accueil avec les boutons
    #[Route('/home', name: 'home')]
    public function home()
    {
        return $this->render('index.html.twig');  // Redirige vers le menu principal
    }

    // Route pour afficher toutes les commissions
    #[Route('/commissions', name: 'commission_index')]
    public function index()
    {
        $commissions = $this->entityManager->getRepository(Commission::class)->findAll();
        return $this->render('commission/showCommission.twig', [
            'commissions' => $commissions,
        ]);
    }

    // Route pour afficher le formulaire de création d'une commission
    #[Route('/commission/create', name: 'commission_create')]
    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            
            $commission = new Commission();
            $commission->setNom($data['name']);  // Utilisez "setNom" ici
            $commission->setDescription($data['description']);

            // Initialisation de la date de création à la date actuelle
            $commission->setDateCreation(new \DateTime());  // Date de création par défaut

            $this->entityManager->persist($commission);
            $this->entityManager->flush();

            return $this->redirectToRoute('commission_index');
        }

        return $this->render('commission/createCommission.twig');
    }

    // Route pour éditer une commission
    #[Route('/commission/{id}/edit', name: 'commission_edit')]
    public function edit(int $id, Request $request)
    {
        $commission = $this->entityManager->getRepository(Commission::class)->find($id);

        // Si la commission n'existe pas, renvoyer une erreur
        if (!$commission) {
            throw $this->createNotFoundException('No commission found for id ' . $id);
        }

        // Si le formulaire est soumis, mettre à jour la commission
        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            // Mettre à jour le nom et la description de la commission
            $commission->setNom($data['name']);
            $commission->setDescription($data['description']);

            // Sauvegarder les modifications dans la base de données
            $this->entityManager->flush();

            // Rediriger vers la liste des commissions
            return $this->redirectToRoute('commission_index');
        }

        // Renvoyer la vue avec les données de la commission
        return $this->render('commission/editCommission.twig', [
            'commission' => $commission
        ]);
    }

    // Route pour supprimer une commission
    #[Route('/commission/{id}/delete', name: 'commission_delete', methods: ['POST'])]
    public function delete(int $id)
    {
        $commission = $this->entityManager->getRepository(Commission::class)->find($id);

        // Si la commission n'existe pas, renvoyer une erreur
        if (!$commission) {
            throw $this->createNotFoundException('No commission found for id ' . $id);
        }

        // Supprimer la commission
        $this->entityManager->remove($commission);
        $this->entityManager->flush();

        // Rediriger vers la liste des commissions
        return $this->redirectToRoute('commission_index');
    }

    // Route pour éditer les utilisateurs d'une commission
    #[Route('/commission/{id}/editUsers', name: 'commission_users_edit')]
    public function editUsers(int $id, Request $request)
    {
        $commission = $this->entityManager->getRepository(Commission::class)->find($id);

        // Si la commission n'existe pas, renvoyer une erreur
        if (!$commission) {
            throw $this->createNotFoundException('No commission found for id ' . $id);
        }

        // Récupérer tous les utilisateurs pour afficher la liste
        $utilisateurs = $this->entityManager->getRepository(Utilisateur::class)->findAll();

        // Si le formulaire est soumis pour ajouter ou supprimer un utilisateur
        if ($request->isMethod('POST')) {
            $utilisateurId = $request->get('utilisateur_id');
            $utilisateur = $this->entityManager->getRepository(Utilisateur::class)->find($utilisateurId);

            if ($utilisateur) {
                // Vérifier si l'utilisateur est déjà inscrit à cette commission
                $existingLink = $this->entityManager->getRepository(LinkCommUser::class)
                    ->findOneBy(['utilisateur' => $utilisateur, 'commission' => $commission]);

                if ($existingLink) {
                    // Si l'utilisateur est déjà inscrit, supprimer la relation
                    $this->entityManager->remove($existingLink);
                    $this->entityManager->flush();
                } else {
                    // Ajouter l'utilisateur à la commission
                    $linkCommUser = new LinkCommUser();
                    $linkCommUser->setUtilisateur($utilisateur);
                    $linkCommUser->setCommission($commission);

                    $this->entityManager->persist($linkCommUser);
                    $this->entityManager->flush();
                }
            }

            return $this->redirectToRoute('commission_users_edit', ['id' => $id]);
        }

        return $this->render('commission/editUsers.twig', [
            'commission' => $commission,
            'utilisateurs' => $utilisateurs,
        ]);
    }
}
