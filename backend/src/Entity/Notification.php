<?php
// src/Entity/Notification.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Notification
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: "utilisateur_id", referencedColumnName: "id")]
    private $utilisateur;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Commission::class)]
    #[ORM\JoinColumn(name: "commission_id", referencedColumnName: "id")]
    private $commission;

    #[ORM\Column(type: 'boolean')]
    private $notificationsEnabled;

    #[ORM\Column(type: 'integer')]
    private $messagesRates = 0;  // Compteur des messages non lus

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateLastChecked;  // Date de la dernière vérification des messages

    public function __construct(Utilisateur $utilisateur, Commission $commission)
    {
        $this->utilisateur = $utilisateur;
        $this->commission = $commission;
        $this->notificationsEnabled = true; // Par défaut, les notifications sont activées
        $this->messagesRates = 0; // Aucun message non lu initialement
        $this->dateLastChecked = new \DateTime(); // Initialisation à la date actuelle
    }

    // Getters et Setters
    public function getMessagesRates(): int
    {
        return $this->messagesRates;
    }

    public function setMessagesRates(int $messagesRates): self
    {
        $this->messagesRates = $messagesRates;
        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function getCommission(): ?Commission
    {
        return $this->commission;
    }

    public function getNotificationsEnabled(): bool
    {
        return $this->notificationsEnabled;
    }

    public function setNotificationsEnabled(bool $notificationsEnabled): self
    {
        $this->notificationsEnabled = $notificationsEnabled;
        return $this;
    }

    // Getter et Setter pour la date de la dernière consultation
    public function getDateLastChecked(): ?\DateTimeInterface
    {
        return $this->dateLastChecked;
    }

    public function setDateLastChecked(?\DateTimeInterface $dateLastChecked): self
    {
        $this->dateLastChecked = $dateLastChecked;
        return $this;
    }

    // Méthode pour mettre à jour le compteur de messages non lus
    public function updateMessagesRates(EntityManagerInterface $entityManager): void
    {
        if ($this->notificationsEnabled) {
            // Récupérer les messages non lus depuis la dernière consultation
            $messageCount = $entityManager->getRepository(Message::class)->count([
                'commission' => $this->commission,
                'createdAt' => ['gt' => $this->dateLastChecked ?? new \DateTime()]
            ]);

            $this->messagesRates = $messageCount;
            $entityManager->flush();
        }
    }
}
