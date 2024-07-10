<?php

// src/Controller/CommissionController.php
namespace App\Controller;

use App\Entity\Commission;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommissionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commission', name: 'commission_index')]
    public function index(): Response
    {
        $commissions = $this->entityManager->getRepository(Commission::class)->findAll();
        return $this->render('commission/index.html.twig', [
            'commissions' => $commissions,
        ]);
    }

    #[Route('/commission/create', name: 'commission_create')]
    public function create(Request $request): Response
    {
        $commission = new Commission();
        // Handle form submission and save new commission...
        return $this->render('commission/create.html.twig', [
            'commission' => $commission,
        ]);
    }

    #[Route('/commission/{id}', name: 'commission_show')]
    public function show(int $id): Response
    {
        $commission = $this->entityManager->getRepository(Commission::class)->find($id);
        return $this->render('commission/show.html.twig', [
            'commission' => $commission,
        ]);
    }

    #[Route('/commission/{id}/edit', name: 'commission_edit')]
    public function edit(Request $request, int $id): Response
    {
        $commission = $this->entityManager->getRepository(Commission::class)->find($id);
        // Handle form submission and update commission...
        return $this->render('commission/edit.html.twig', [
            'commission' => $commission,
        ]);
    }
}

?>