<?php

namespace App\Controller;

use App\Entity\Commission;
use App\Entity\Message;
use App\Entity\Utilisateur;
use App\Entity\Notification;
use App\Entity\LinkCommUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class ChatController extends AbstractController
{
    #[Route('/chat/index', name: 'chat_index')]
public function index(EntityManagerInterface $entityManager): Response
{
    // Récupérer l'utilisateur connecté
    $user = $this->getUser();

    // Récupérer toutes les commissions auxquelles l'utilisateur est lié
    $commissions = $entityManager->getRepository(Commission::class)->findAll();

    // Initialiser les données nécessaires pour les notifications
    $unreadMessagesCount = [];
    $notificationsStatus = [];

    foreach ($commissions as $commission) {
        // Récupérer les notifications pour l'utilisateur et la commission
        $notification = $entityManager->getRepository(Notification::class)->findOneBy([
            'utilisateur' => $user,
            'commission' => $commission
        ]);

        // Récupérer le nombre de messages non lus
        $unreadMessagesCount[$commission->getId()] = $notification ? $notification->getMessagesRates() : 0;

        // Vérifier si les notifications sont activées
        $notificationsStatus[$commission->getId()] = $notification ? $notification->getNotificationsEnabled() : false;
    }

    return $this->render('chat/index.html.twig', [
        'commissions' => $commissions,
        'unreadMessagesCount' => $unreadMessagesCount,
        'notificationsStatus' => $notificationsStatus,
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

        // Si la notification existe et que l'utilisateur n'a pas encore consulté le chat, mettre à jour messagesRates et dateLastChecked
        if ($notification) {
            // Réinitialiser le compteur de messages non lus (messagesRates) à 0
            $notification->setMessagesRates(0);

            // Mettre à jour la date de la dernière vérification des messages
            $notification->setDateLastChecked(new \DateTime());

            // Sauvegarder les modifications dans la base de données
            $entityManager->flush();
        }

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
            return new JsonResponse(['error' => 'Invalid data'], Response::HTTP_BAD_REQUEST);
        }

        // Vérification de la validité de la commission
        $commission = $entityManager->getRepository(Commission::class)->find($data['commission']);
        if (!$commission) {
            return new JsonResponse(['error' => 'Invalid commission'], Response::HTTP_BAD_REQUEST);
        }

        // Créer un nouveau message
        $message = new Message();
        $message->setContent($data['content']);
        $message->setSender($this->getUser()); // Utilisateur connecté
        $message->setCommission($commission);

        // Persist du message
        try {
            $entityManager->persist($message);
            $entityManager->flush();
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Failed to save message'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Récupérer tous les utilisateurs qui ont des notifications activées pour cette commission
        $notifications = $entityManager->getRepository(Notification::class)->findBy([
            'commission' => $commission,
            'notificationsEnabled' => true // Ne récupérer que ceux qui ont activé les notifications
        ]);

        foreach ($notifications as $notification) {
            $user = $notification->getUtilisateur();

            // S'assurer que l'utilisateur n'est pas celui qui a posté le message
            if ($user !== $this->getUser()) {
                // Incrémenter messagesRates pour cet utilisateur
                $notification->setMessagesRates($notification->getMessagesRates() + 1);
                $entityManager->flush();  // Sauvegarder les modifications
            }
        }

        // Retourner une réponse JSON avec le message
        return $this->json([
            'status' => 'Message créé avec succès',
            'message' => [
                'id' => $message->getId(),
                'content' => $message->getContent(),
                'sender' => $message->getSender()->getNom(),
                'createdAt' => $message->getCreatedAt()->format('Y-m-d H:i:s'),
                'commission' => $message->getCommission()->getNom(),
            ]
        ], Response::HTTP_CREATED);
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