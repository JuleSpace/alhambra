<?php

namespace App\Controller;

use App\Entity\Commission;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommissionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Route pour afficher la page d'accueil avec les boutons
    #[Route('/commissions/index', name: 'commission_home')]
    public function home()
    {
        return $this->render('commission/indexCommission.twig');
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

        if (!$commission) {
            throw $this->createNotFoundException('No commission found for id ' . $id);
        }

        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            
            $commission->setNom($data['name']);  // Utilisez "setNom" ici
            $commission->setDescription($data['description']);
            
            $this->entityManager->flush();
            
            return $this->redirectToRoute('commission_index');
        }

        return $this->render('commission/editCommission.twig', [
            'commission' => $commission,
        ]);
    }

    // Route pour supprimer une commission
    #[Route('/commission/{id}/delete', name: 'commission_delete', methods: ['POST'])]
    public function delete(int $id)
    {
        $commission = $this->entityManager->getRepository(Commission::class)->find($id);

        if (!$commission) {
            throw $this->createNotFoundException('No commission found for id ' . $id);
        }

        $this->entityManager->remove($commission);
        $this->entityManager->flush();

        return $this->redirectToRoute('commission_index');
    }
}
