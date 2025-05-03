<?php

class ConfigDao
{
    private string $nomBD;
    private string $nomUtilisateur;
    private string $motDePasse;
    private string $adresseHote;
    private int $port;
    private string $encodage;
    private string $moteur;

    public function __construct(
        string $nomBD,
        string $nomUtilisateur,
        string $motDePasse,
        string $adresseHote = 'localhost',
        int $port = 3306,
        string $encodage = 'utf8mb4',
        string $moteur = 'mysql'
    )
    {
        $this->nomBD = $nomBD;
        $this->nomUtilisateur = $nomUtilisateur;
        $this->motDePasse = $motDePasse;
        $this->adresseHote = $adresseHote;
        $this->port = $port;
        $this->encodage = $encodage;
        $this->moteur = $moteur;
    }

    public function creerChaineConnexion(): string
    {
        return "$this->moteur:dbname=$this->nomBD;host=$this->adresseHote;port=$this->port;charset=$this->encodage;";
    }

    public function getNomUtilisateur(): string
    {
        return $this->nomUtilisateur;
    }

    public function getMotDePasse(): string
    {
        return $this->motDePasse;
    }
}
