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
    // Route pour afficher l'index des commissions (affiche uniquement les commissions liées à l'utilisateur)
    #[Route('/chat/index', name: 'chat_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        // Récupérer les commissions auxquelles l'utilisateur est lié via la table link_comm_user
        $commissions = $entityManager->getRepository(Commission::class)->createQueryBuilder('c')
            ->innerJoin('c.users', 'u') // Jointure avec les utilisateurs
            ->where('u.id = :userId') // Condition de filtrage pour l'utilisateur
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();

        return $this->render('chat/index.html.twig', [
            'commissions' => $commissions,
        ]);
    }

    // Route pour afficher le chat d'une commission spécifique
    #[Route('/chat/{commission}/chat', name: 'chat_show')]
    public function show(int $commissionId, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        // Récupérer la commission par son ID
        $commission = $entityManager->getRepository(Commission::class)->find($commissionId);

        if (!$commission) {
            throw $this->createNotFoundException('Commission non trouvée.');
        }

        // Vérification si l'utilisateur est bien lié à cette commission
        $userIsLinked = in_array($user, $commission->getUsers()->toArray(), true);

        if (!$userIsLinked) {
            // Si l'utilisateur n'est pas lié à la commission, renvoyer une erreur
            throw $this->createNotFoundException('Vous n\'êtes pas autorisé à accéder à ce chat.');
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
