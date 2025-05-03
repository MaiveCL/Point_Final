<?php

class Jeu
{
    private int $id;
    private string $nom;
    private string $urlImageJeu;

    public function __construct(string $nom, string $urlImageJeu, int $id = 0)
    {
        $this->setId($id);
        $this->setNom($nom);
        $this->setUrlImageJeu($urlImageJeu);
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
            throw new Exception("Le jeu '$nom' doit être entre 1 et 50 caractères.");
        $this->nom = $nom;
        return $this;
    }

    public function getUrlImageJeu(): string
    {
        return $this->urlImageJeu;
    }

    public function setUrlImageJeu(string $urlImageJeu): self
    {
        if (filter_var($urlImageJeu, FILTER_VALIDATE_URL) === false)
            throw new Exception("L'url de l'image du jeu n'est pas valide.");
        $this->urlImageJeu = $urlImageJeu;
        return $this;
    }
}
