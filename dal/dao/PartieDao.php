<?php

class PartieDao extends BaseDao
{
    public function __construct(ConfigDao $config)
    {
        parent::__construct($config);
    }

    // ***** MA FONCTION pour compter les parties jouées *****
    // Pas besoin de prepare() ici : requête sans paramètres utilisateurs = plus performant avec query().
    public function compterParties(): int
    {
        $connexion = $this->getConnexion();
        $requete = $connexion->query("SELECT COUNT(*) FROM partie");
        return (int) $requete->fetchColumn();
    }
}
