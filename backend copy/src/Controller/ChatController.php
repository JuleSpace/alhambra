<?php

// src/Controller/ChatController.php
namespace App\Controller;

use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;  // Correct namespace

class ChatController extends AbstractController
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    #[Route('/chat', name: 'chat_index')]
    public function index(): Response
    {
        $messages = $this->entityManager->getRepository(Message::class)->findBy([], ['timestamp' => 'ASC']);

        return $this->render('chat/index.html.twig', [
            'messages' => $messages,
        ]);
    }

    #[Route('/chat/send', name: 'chat_send', methods: ['POST'])]
    public function send(Request $request): Response
    {
        $content = $request->request->get('content');

        $message = new Message();
        $message->setContent($content);
        $message->setTimestamp(new \DateTime());
        $message->setSender($this->security->getUser());

        $this->entityManager->persist($message);
        $this->entityManager->flush();

        return $this->json([
            'content' => $message->getContent(),
            'timestamp' => $message->getTimestamp()->format('H:i'),
            'sender' => [
                'nom' => $message->getSender()->getNom(),
                'prenom' => $message->getSender()->getPrenom(),
            ],
        ]);
    }
}



?>