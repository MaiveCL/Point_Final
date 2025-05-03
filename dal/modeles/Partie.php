<?php

class Partie
{
    private int $id;
    private ?DateTime $dateCreation;
    private int $joueur1Id;
    private ?Utilisateur $joueur1;
    private int $joueur2Id;
    private ?Utilisateur $joueur2;
    private int $scoreJoueur1;
    private int $scoreJoueur2;
    private int $jeuId;
    private ?Jeu $jeu;

    public function __construct(
        ?DateTime $dateCreation,
        int $joueur1Id,
        int $joueur2Id,
        int $scoreJoueur1,
        int $scoreJoueur2,
        int $jeuId,
        int $id = 0
    )
    {
        $this->setId($id);
        $this->setDateCreation($dateCreation);
        $this->setIdJoueur1Et2($joueur1Id, $joueur2Id);
        $this->setScoreJoueur1($scoreJoueur1);
        $this->setScoreJoueur2($scoreJoueur2);
        $this->setjeuId($jeuId);
        $this->joueur1 = null;
        $this->joueur2 = null;
        $this->jeu = null;
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

    public function getDateCreation(): ?DateTime
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?DateTime $dateCreation): self
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function getJoueur1Id(): int
    {
        return $this->joueur1Id;
    }

    public function getJoueur2Id(): int
    {
        return $this->joueur2Id;
    }

    public function setIdJoueur1ET2(int $joueur1Id, int $joueur2Id): self
    {
        $this->joueur1Id = $joueur1Id;
        $this->joueur2Id = $joueur2Id;
        return $this;
    }

    public function getJoueur1(): ?Utilisateur
    {
        return $this->joueur1;
    }

    public function setJoueur1(?Utilisateur $joueur1): self
    {
        $this->joueur1 = $joueur1;
        return $this;
    }

    public function getJoueur2(): ?Utilisateur
    {
        return $this->joueur2;
    }

    public function setJoueur2(?Utilisateur $joueur2): self
    {
        $this->joueur2 = $joueur2;
        return $this;
    }

    public function getScoreJoueur1(): int
    {
        return $this->scoreJoueur1;
    }

    public function setScoreJoueur1(int $scoreJoueur1): self
    {
        $this->scoreJoueur1 = $scoreJoueur1;
        return $this;
    }

    public function getScoreJoueur2(): int
    {
        return $this->scoreJoueur2;
    }

    public function setScoreJoueur2(int $scoreJoueur2): self
    {
        $this->scoreJoueur2 = $scoreJoueur2;
        return $this;
    }

    public function getjeuId(): int
    {
        return $this->jeuId;
    }

    public function setjeuId(int $jeuId): self
    {
        $this->jeuId = $jeuId;
        return $this;
    }

    public function getJeu(): ?Jeu
    {
        return $this->jeu;
    }

    public function setJeu(?Jeu $jeu): self
    {
        $this->jeu = $jeu;
        return $this;
    }
}
