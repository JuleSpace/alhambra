<?php

// src/Controller/ChatController.php
namespace App\Controller;

use App\Entity\Message;
use App\Entity\Commission;
use App\Entity\Utilisateur;
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
    #[Route('/chat/{commission}', name: 'chat_show')]
    public function index(Commission $commission, MessageRepository $messageRepository): Response
    {
        // Récupérer l'utilisateur connecté
        $utilisateur = $this->getUser();

        // Récupérer les messages associés à cette commission et à cet utilisateur
        $messages = $messageRepository->findBy(
            ['commission' => $commission, 'sender' => $utilisateur],  // Critères de recherche
            ['createdAt' => 'DESC']                                     // Critères de tri par date
        );

        // Vérifiez si les messages sont récupérés correctement
        if (empty($messages)) {
            return $this->render('chat/index.html.twig', [
                'commission' => $commission,
                'utilisateur' => $utilisateur,
                'messages' => [],
                'error' => 'Aucun message trouvé pour cette commission et utilisateur.'
            ]);
        }

        // Passer la commission, l'utilisateur et les messages à la vue Twig
        return $this->render('chat/index.html.twig', [
            'commission' => $commission,
            'utilisateur' => $utilisateur,
            'messages' => $messages
        ]);
    }



    #[Route('/api/chat/messages', name: 'chat_messages', methods: ['GET'])]
    public function getMessages(Request $request, MessageRepository $messageRepository): JsonResponse
    {
        $commissionId = $request->query->get('commission');
        
        // Récupérer les messages selon la commission ou tous les messages si commission est absente
        $messages = $commissionId 
            ? $messageRepository->findBy(['commission' => $commissionId], ['createdAt' => 'ASC']) 
            : $messageRepository->findBy([], ['createdAt' => 'ASC']);
        
        // Préparer les données des messages pour la réponse JSON
        $data = array_map(function($msg) {
            // Vérifiez si l'expéditeur existe
            $senderName = $msg->getSender() ? $msg->getSender()->getUsername() : 'Inconnu'; // Valeur par défaut si sender est null
            
            return [
                'id' => $msg->getId(),
                'content' => $msg->getContent(),
                'sender' => $senderName,  // Assurez-vous que sender est correctement défini
                'createdAt' => $msg->getCreatedAt()->format('Y-m-d H:i:s'),
                'commission' => $msg->getCommission() ? $msg->getCommission()->getName() : null,
            ];
        }, $messages);
        
        // Retourner la réponse JSON avec les messages
        return $this->json($data); 
    }
    

    #[Route('/api/chat/messages', name: 'chat_message_create', methods: ['POST'])]
    public function createMessage(Request $request, EntityManagerInterface $entityManager, CommissionRepository $commissionRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        // Validation des données
        if (empty($data['content']) || empty($data['commission'])) {
            return new JsonResponse(['error' => 'Invalid data'], JsonResponse::HTTP_BAD_REQUEST);
        }
    
        // Vérification de la validité de la commission
        $commission = $commissionRepository->find($data['commission']);
        if (!$commission) {
            return new JsonResponse(['error' => 'Invalid commission'], JsonResponse::HTTP_BAD_REQUEST);
        }
    
        // Création du message
        $message = new Message();
        $message->setContent($data['content']);
        $message->setSender($this->getUser());  // Utilisation de l'utilisateur connecté
        $message->setCommission($commission);
    
        // Enregistrement du message en base
        $entityManager->persist($message);
        $entityManager->flush();
    
        return $this->json([
            'status' => 'Message créé avec succès',
            'message' => [
                'id' => $message->getId(),
                'content' => $message->getContent(),
                'sender' => $message->getSender()->getUsername(), // Assurez-vous d'utiliser `getUsername()`
                'createdAt' => $message->getCreatedAt()->format('Y-m-d H:i:s'),
                'commission' => $message->getCommission()->getName(),
            ]
        ], JsonResponse::HTTP_CREATED);
    }
    
}
