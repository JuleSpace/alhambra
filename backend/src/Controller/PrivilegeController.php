<?php

// src/Controller/PrivilegeController.php
namespace App\Controller;

use App\Entity\Privilege;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrivilegeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/privilege', name: 'privilege_index')]
    public function index(): Response
    {
        $privileges = $this->entityManager->getRepository(Privilege::class)->findAll();
        return $this->render('privilege/index.html.twig', [
            'privileges' => $privileges,
        ]);
    }

    #[Route('/privilege/create', name: 'privilege_create')]
    public function create(Request $request): Response
    {
        $privilege = new Privilege();
        // Handle form submission and save new privilege...
        return $this->render('privilege/create.html.twig', [
            'privilege' => $privilege,
        ]);
    }

    #[Route('/privilege/{id}', name: 'privilege_show')]
    public function show(int $id): Response
    {
        $privilege = $this->entityManager->getRepository(Privilege::class)->find($id);
        return $this->render('privilege/show.html.twig', [
            'privilege' => $privilege,
        ]);
    }

    #[Route('/privilege/{id}/edit', name: 'privilege_edit')]
    public function edit(Request $request, int $id): Response
    {
        $privilege = $this->entityManager->getRepository(Privilege::class)->find($id);
        // Handle form submission and update privilege...
        return $this->render('privilege/edit.html.twig', [
            'privilege' => $privilege,
        ]);
    }
}



?>