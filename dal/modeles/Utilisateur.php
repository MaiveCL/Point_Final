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
    )
    {
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
        $this->nomUtilisateur = $nomUtilisateur;
        return $this;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getBio(): string
    {
        return $this->bio;
    }

    public function setBio(string $bio): self
    {
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
