<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
#[ORM\Entity]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $nom;

    #[ORM\Column(type: 'string', length: 100)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $password;

    #[ORM\Column(type: 'integer')] // Stockage en tant qu'entier pour le rôle
    private $role = 1; // Rôle par défaut ROLE_USER

    // Getters et Setters

    public function getId(): ?int
    {
        return $this->id;
    }
        /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    // Getter pour `username`
    public function getUsername(): ?string
    {
        return $this->username;
    }

    // Setter pour `username`
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getRole(): int
    {
        return $this->role;
    }

    public function setRole(int $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getRoles(): array
    {
        // Retourne les rôles sous forme de tableau avec le rôle entier
        $roles = [];
        if ($this->role === 1) {
            $roles[] = 'ROLE_USER';
        } elseif ($this->role === 2) {
            $roles[] = 'ROLE_ADMIN';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        // Conversion des rôles sous forme d'entier
        if (in_array('ROLE_ADMIN', $roles)) {
            $this->role = 2;
        } else {
            $this->role = 1;
        }

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        // Effacer les informations sensibles si nécessaire
    }
}
