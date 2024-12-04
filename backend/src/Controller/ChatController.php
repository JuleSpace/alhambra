<?php

namespace App\Controller;

use App\Entity\Commission;
use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ChatController extends AbstractController
{
    // Route pour afficher l'index des commissions (affiche toutes les commissions)
    #[Route('/chat/index', name: 'chat_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Récupérer toutes les commissions auxquelles l'utilisateur est lié (maintenant toutes les commissions)
        $commissions = $entityManager->getRepository(Commission::class)->findAll();

        return $this->render('chat/index.html.twig', [
            'commissions' => $commissions,
        ]);
    }

    // Route pour afficher le chat d'une commission spécifique
    #[Route('/chat/{commissionId}/chat', name: 'chat_show')]
    public function show(int $commissionId, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Récupérer la commission par son ID
        $commission = $entityManager->getRepository(Commission::class)->find($commissionId);

        if (!$commission) {
            throw $this->createNotFoundException('Commission non trouvée.');
        }

        // Récupérer les messages associés à cette commission
        $messages = $entityManager->getRepository(Message::class)->findBy(
            ['commission' => $commission],
            ['createdAt' => 'DESC']
        );

        return $this->render('chat/show.html.twig', [
            'commission' => $commission,
            'user' => $user,
            'messages' => $messages,
        ]);
    }

    // Route pour envoyer un message via l'API
    #[Route('/api/chat/messages', name: 'chat_message_create', methods: ['POST'])]
    public function createMessage(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validation des données
        if (empty($data['content']) || empty($data['commission'])) {
            return new JsonResponse(['error' => 'Invalid data'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Vérification de la validité de la commission
        $commission = $entityManager->getRepository(Commission::class)->find($data['commission']);
        if (!$commission) {
            return new JsonResponse(['error' => 'Invalid commission'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Créer un nouveau message
        $message = new Message();
        $message->setContent($data['content']);
        $message->setSender($this->getUser()); // Utilisateur connecté
        $message->setCommission($commission);

        $entityManager->persist($message);
        $entityManager->flush();

        return $this->json([
            'status' => 'Message créé avec succès',
            'message' => [
                'id' => $message->getId(),
                'content' => $message->getContent(),
                'sender' => $message->getSender()->getUsername(),
                'createdAt' => $message->getCreatedAt()->format('Y-m-d H:i:s'),
                'commission' => $message->getCommission()->getNom(),
            ]
        ], JsonResponse::HTTP_CREATED);
    }
}
