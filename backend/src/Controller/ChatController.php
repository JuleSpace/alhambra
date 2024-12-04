<?php

namespace App\Controller;

use App\Entity\Commission;
use App\Entity\Message;
use App\Entity\Notification;
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

        // Récupérer toutes les commissions auxquelles l'utilisateur est lié
        $commissions = $entityManager->getRepository(Commission::class)->findAll();

        // Initialiser le tableau pour stocker le nombre de messages non lus par commission
        $unreadMessagesCount = [];
        $notificationsStatus = [];

        // Vérifier les notifications de l'utilisateur pour chaque commission
        foreach ($commissions as $commission) {
            // Récupérer les notifications pour l'utilisateur et la commission
            $notification = $entityManager->getRepository(Notification::class)->findOneBy([
                'utilisateur' => $user,
                'commission' => $commission
            ]);

            // Vérifier si les notifications sont activées pour cette commission
            if ($notification && $notification->getNotificationsEnabled()) {
                // Comparer la date de création des messages avec la date de la dernière vérification des notifications
                $dateLastChecked = $notification->getDateLastChecked() ?: new \DateTime();
                $unreadMessagesCount[$commission->getId()] = $entityManager->getRepository(Message::class)->count([
                    'commission' => $commission,
                    'createdAt' => ['gt' => $dateLastChecked->format('Y-m-d H:i:s')] // Formatage de la date ici
                ]);
                $notificationsStatus[$commission->getId()] = true; // Notifications activées
            } else {
                $unreadMessagesCount[$commission->getId()] = 0; // Pas de messages non lus si notifications désactivées
                $notificationsStatus[$commission->getId()] = false; // Notifications désactivées
            }
        }

        return $this->render('chat/index.html.twig', [
            'commissions' => $commissions,
            'unreadMessagesCount' => $unreadMessagesCount, // Passer le nombre de messages non lus à la vue
            'notificationsStatus' => $notificationsStatus, // Passer le statut des notifications à la vue
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

        // Récupérer l'état des notifications pour cette commission
        $notification = $entityManager->getRepository(Notification::class)->findOneBy([
            'utilisateur' => $user,
            'commission' => $commission
        ]);

        return $this->render('chat/show.html.twig', [
            'commission' => $commission,
            'user' => $user,
            'messages' => $messages,
            'notification' => $notification, // Passer l'objet notification à la vue pour vérifier son état
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

    // Route pour activer/désactiver les notifications pour une commission donnée
    #[Route('/chat/{commissionId}/toggle-notifications', name: 'toggle_notifications', methods: ['POST'])]
    public function toggleNotifications(int $commissionId, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Récupérer la commission par son ID
        $commission = $entityManager->getRepository(Commission::class)->find($commissionId);

        if (!$commission) {
            throw $this->createNotFoundException('Commission non trouvée.');
        }

        // Vérifier si la notification existe déjà pour cette commission et cet utilisateur
        $notification = $entityManager->getRepository(Notification::class)->findOneBy([
            'utilisateur' => $user,
            'commission' => $commission
        ]);

        if ($notification) {
            // Si les notifications sont activées, les désactiver
            $notification->setNotificationsEnabled(!$notification->getNotificationsEnabled());
        } else {
            // Si aucune notification, créer une nouvelle notification activée
            $notification = new Notification($user, $commission);
            $entityManager->persist($notification);
        }

        // Sauvegarder les modifications dans la base de données
        $entityManager->flush();

        // Rediriger vers la page des commissions avec les notifications mises à jour
        return $this->redirectToRoute('chat_index');
    }
}
