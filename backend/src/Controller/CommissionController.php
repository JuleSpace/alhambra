<?php

namespace App\Controller;

use App\Entity\Commission;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommissionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/commissions', name: 'commission_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $commissions = $this->entityManager->getRepository(Commission::class)->findAll();

        $data = array_map(function ($commission) {
            return [
                'id' => $commission->getId(),
                'name' => $commission->getName(),
                'description' => $commission->getDescription(),
                // Ajoutez les champs nécessaires
            ];
        }, $commissions);

        return $this->json($data);
    }

    #[Route('/api/commissions', name: 'commission_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $commission = new Commission();
        $commission->setName($data['name']);
        $commission->setDescription($data['description']);
        // Ajoutez les setters nécessaires

        $this->entityManager->persist($commission);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Commission created successfully',
            'id' => $commission->getId(),
        ], JsonResponse::HTTP_CREATED);
    }

    #[Route('/api/commissions/{id}', name: 'commission_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $commission = $this->entityManager->getRepository(Commission::class)->find($id);

        if (!$commission) {
            return $this->json(['message' => 'Commission not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $commission->getId(),
            'name' => $commission->getName(),
            'description' => $commission->getDescription(),
            // Ajoutez les champs nécessaires
        ];

        return $this->json($data);
    }

    #[Route('/api/commissions/{id}', name: 'commission_edit', methods: ['PUT'])]
    public function edit(Request $request, int $id): JsonResponse
    {
        $commission = $this->entityManager->getRepository(Commission::class)->find($id);

        if (!$commission) {
            return $this->json(['message' => 'Commission not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $commission->setName($data['name'] ?? $commission->getName());
        $commission->setDescription($data['description'] ?? $commission->getDescription());
        // Ajoutez les setters nécessaires

        $this->entityManager->flush();

        return $this->json(['message' => 'Commission updated successfully']);
    }

    #[Route('/api/commissions/{id}', name: 'commission_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $commission = $this->entityManager->getRepository(Commission::class)->find($id);

        if (!$commission) {
            return $this->json(['message' => 'Commission not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($commission);
        $this->entityManager->flush();

        return $this->json(['message' => 'Commission deleted successfully']);
    }
}

