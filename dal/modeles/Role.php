<?php

class Role
{
    private int $id;
    private string $nom;

    public function __construct(string $nom, int $id = 0)
    {
        $this->setId($id);
        $this->setNom($nom);
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

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $nom = trim($nom);
        if (empty($nom) || strlen($nom) > 50)
            throw new Exception("Le rôle '$nom' doit être entre 1 et 50 caractères.");
        $this->nom = $nom;
        return $this;
    }
}
