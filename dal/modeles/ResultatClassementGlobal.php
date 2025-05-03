<?php

class ResultatClassementGlobal
{
    private int $joueurId;
    private string $nomComplet;
    private int $nbPartiesGagnees;
    private int $nbPartiesPerdues;
    private int $nbPartiesEgales;
    private int $nbPartiesJouees;
    private int $scoreTotal;

    public function __construct(
        int $joueurId,
        string $nomComplet,
        int $nbPartiesGagnees,
        int $nbPartiesPerdues,
        int $nbPartiesEgales,
        int $nbPartiesJouees,
        int $scoreTotal
    )
    {
        $this->joueurId = $joueurId;
        $this->nomComplet = $nomComplet;
        $this->nbPartiesGagnees = $nbPartiesGagnees;
        $this->nbPartiesPerdues = $nbPartiesPerdues;
        $this->nbPartiesEgales = $nbPartiesEgales;
        $this->nbPartiesJouees = $nbPartiesJouees;
        $this->scoreTotal = $scoreTotal;
    }

    public function getJoueurId(): int
    {
        return $this->joueurId;
    }

    public function getNomComplet(): string
    {
        return $this->nomComplet;
    }

    public function getNbPartiesGagnees(): int
    {
        return $this->nbPartiesGagnees;
    }

    public function getNbPartiesPerdues(): int
    {
        return $this->nbPartiesPerdues;
    }

    public function getNbPartiesEgales(): int
    {
        return $this->nbPartiesEgales;
    }

    public function getNbPartiesJouees(): int
    {
        return $this->nbPartiesJouees;
    }

    public function getScoreTotal(): int
    {
        return $this->scoreTotal;
    }
}
