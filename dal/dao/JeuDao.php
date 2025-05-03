<?php

class JeuDao extends BaseDao
{
    public function __construct(ConfigDao $config)
    {
        parent::__construct($config);
    }

    public function selectAll(): array
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare("SELECT * FROM jeu");
        $requete->execute();

        $jeux = [];
        while ($enregistrement = $requete->fetch())
        {
            $jeux[] = new Jeu($enregistrement['nom'], $enregistrement['url_jeu'],  $enregistrement['id']);
        }

        return $jeux;
    }


    public function select(int $id): ?Jeu
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare("SELECT * FROM jeu WHERE id=:id");
        $requete->bindValue(":id", $id);
        $requete->execute();

        $jeu = null;
        if ($enregistrement = $requete->fetch())
        {
            $jeu = new Jeu($enregistrement['nom'], $enregistrement['url_jeu'], $enregistrement['id']);
        }

        return $jeu;
    }
}
