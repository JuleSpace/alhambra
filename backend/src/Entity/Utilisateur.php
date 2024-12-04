<?php
// src/Entity/Utilisateur.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Utilisateur
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

    #[ORM\Column(type: 'string', length: 100)]
    private $password;

    #[ORM\Column(type: 'integer')]
    private $roles = [];

    #[ORM\ManyToOne(targetEntity: Commission::class)]
    #[ORM\JoinColumn(name: 'id_commission', referencedColumnName: 'id', nullable: true)]
    private $commission;

    // Getters and Setters

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        // Vérifie que $this->roles est bien un tableau
        $roles = is_array($this->roles) ? $this->roles : [];
        
        // Ajoute le rôle par défaut 'ROLE_USER'
        $roles[] = 'ROLE_USER';
    
        return array_unique($roles);
    }
    

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getCommission(): ?Commission
    {
        return $this->commission;
    }

    public function setCommission(?Commission $commission): self
    {
        $this->commission = $commission;

        return $this;
    }
}
