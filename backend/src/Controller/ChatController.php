<?php

// src/Controller/ChatController.php
namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use App\Repository\CommissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ChatController extends AbstractController
{
    #[Route('/chat', name: 'chat_index')]
    public function index(MessageRepository $messageRepository): Response
    {
        // Récupère tous les messages
        $messages = $messageRepository->findBy([], ['createdAt' => 'DESC']);

        // Passe les messages à la vue Twig
        return $this->render('chat/index.html.twig', [
            'messages' => $messages,
        ]);
    }

    #[Route('/api/chat/messages', name: 'chat_messages', methods: ['GET'])]
    public function getMessages(
        Request $request, 
        MessageRepository $messageRepository, 
    ): JsonResponse {
        $commissionId = $request->query->get('commission');
        $messages = $commissionId 
            ? $messageRepository->findBy(['commission' => $commissionId], ['createdAt' => 'ASC']) 
            : $messageRepository->findBy([], ['createdAt' => 'ASC']);
    
        $data = array_map(fn($msg) => [
            'id' => $msg->getId(),
            'content' => $msg->getContent(),
            'sender' => $msg->getSender()->getNom(),
            'createdAt' => $msg->getCreatedAt()->format('Y-m-d H:i:s'),
            'commission' => $msg->getCommission()?->getName(),
        ], $messages);
    
        return new JsonResponse($data);
    }
    

    #[Route('/api/chat/messages', name: 'chat_message_create', methods: ['POST'])]
    public function createMessage(Request $request, EntityManagerInterface $entityManager, CommissionRepository $commissionRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['content']) || empty($data['commission'])) {
            return new JsonResponse(['error' => 'Invalid data'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $commission = $commissionRepository->find($data['commission']);
        if (!$commission) {
            return new JsonResponse(['error' => 'Invalid commission'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $message = new Message();
        $message->setContent($data['content']);
        $message->setSender($this->getUser());
        $message->setCommission($commission);

        $entityManager->persist($message);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Message created successfully!'], JsonResponse::HTTP_CREATED);
    }
}
