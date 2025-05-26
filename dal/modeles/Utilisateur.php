<?php

class Utilisateur
{
    private int $id;
    private string $nomUtilisateur;
    private string $prenom;
    private string $nom;
    private string $bio;
    private ?DateTime $dateCreation;
    private int $roleId;
    private ?Role $role;
    private string $urlAvatar;
    private string $hash;

    public function __construct(
        string $nomUtilisateur,
        string $prenom,
        string $nom,
        string $bio,
        ?DateTime $dateCreation,
        int $roleId,
        string $urlAvatar,
        string $hash,
        int $id = 0
    ) {
        $this->setId($id);
        $this->setNomUtilisateur($nomUtilisateur);
        $this->setPrenom($prenom);
        $this->setNom($nom);
        $this->setBio($bio);
        $this->setDateCreation($dateCreation);
        $this->setRoleId($roleId);
        $this->setUrlAvatar($urlAvatar);
        $this->setHash($hash);
        $this->role = null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNomUtilisateur(): string
    {
        return $this->nomUtilisateur;
    }

    public function setNomUtilisateur(string $nomUtilisateur): self
    {
        $nomUtilisateur = trim($nomUtilisateur);
        if (empty($nomUtilisateur) || strlen($nomUtilisateur) > 50 || !ctype_alnum($nomUtilisateur)) {
            throw new Exception("Le nom d'utilisateur doit être alphanumérique et contenir entre 1 et 50 caractères.");
        }
        $this->nomUtilisateur = $nomUtilisateur;
        return $this;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $prenom = trim($prenom);
        if (empty($prenom) || strlen($prenom) > 50) {
            throw new Exception("Le prénom doit contenir entre 1 et 50 caractères.");
        }
        $this->prenom = $prenom;
        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $nom = trim($nom);
        if (empty($nom) || strlen($nom) > 50) {
            throw new Exception("Le nom doit contenir entre 1 et 50 caractères.");
        }
        $this->nom = $nom;
        return $this;
    }

    public function getBio(): string
    {
        return $this->bio;
    }

    public function setBio(string $bio): self
    {
        $bio = trim($bio);
        if (strlen($bio) > 255) {
            throw new Exception("La bio ne doit pas dépasser 255 caractères.");
        }
        $this->bio = $bio;
        return $this;
    }

    public function getDateCreation(): ?DateTime
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?DateTime $dateCreation): self
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function setRoleId(int $roleId): self
    {
        $this->roleId = $roleId;
        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getUrlAvatar(): string
    {
        return $this->urlAvatar;
    }

    public function setUrlAvatar(string $urlAvatar): self
    {
        $urlAvatar = trim($urlAvatar);
        if (!filter_var($urlAvatar, FILTER_VALIDATE_URL)) {
            throw new Exception("L'URL de l'avatar est invalide.");
        }
        $this->urlAvatar = $urlAvatar;
        return $this;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;
        return $this;
    }
}
