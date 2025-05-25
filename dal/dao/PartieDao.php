<?php

class PartieDao extends BaseDao
{
    private UtilisateurDao $utilisateurDao;
    private JeuDao $jeuDao;

    public function __construct(ConfigDao $config)
    {
        parent::__construct($config);
        $this->utilisateurDao = new UtilisateurDao($config);
        $this->jeuDao = new JeuDao($config);
    }

    public function selectToutesParties(): array {
    $connexion = $this->getConnexion();
    $sql = "SELECT * FROM partie ORDER BY date_creation DESC";
    $requete = $connexion->prepare($sql);
    $requete->execute();

    $parties = [];
    while ($enregistrement = $requete->fetch()) {
        $partie = $this->construirePartie($enregistrement);
        $partie->setJoueur1($this->utilisateurDao->select($partie->getJoueur1Id()));
        $partie->setJoueur2($this->utilisateurDao->select($partie->getJoueur2Id()));
        $partie->setJeu($this->jeuDao->select($partie->getJeuId()));
        $parties[] = $partie;
    }

    return $parties;
}


    public function selectDernieresParties(int $limite = 6): array {
    $connexion = $this->getConnexion();
    $sql = "SELECT * FROM partie ORDER BY date_creation DESC LIMIT :limite";
    $requete = $connexion->prepare($sql);
    $requete->bindValue(':limite', $limite, PDO::PARAM_INT);
    $requete->execute();

    $parties = [];
    while ($enregistrement = $requete->fetch()) {
        $partie = $this->construirePartie($enregistrement);
        $partie->setJoueur1($this->utilisateurDao->select($partie->getJoueur1Id()));
        $partie->setJoueur2($this->utilisateurDao->select($partie->getJoueur2Id()));
        $partie->setJeu($this->jeuDao->select($partie->getJeuId()));
        $parties[] = $partie;
    }

    return $parties;
}

    // ***** MA FONCTION pour compter les parties jouées *****
    // Pas besoin de prepare() ici : requête sans paramètres utilisateurs = plus performant avec query().
    public function compterParties(): int
    {
        $connexion = $this->getConnexion();
        $requete = $connexion->query("SELECT COUNT(*) FROM partie");
        return (int) $requete->fetchColumn();
    }

    public function selectParJoueurId(int $joueurId): array
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare("SELECT * FROM partie WHERE j1_id = :joueurId OR j2_id = :joueurId ORDER BY date_creation DESC");
        $requete->bindValue(":joueurId", $joueurId);
        $requete->execute();

        $parties = [];
        while ($enregistrement = $requete->fetch()) {
            $partie = $this->construirePartie($enregistrement);
            $partie->setJoueur1($this->utilisateurDao->select($partie->getJoueur1Id()));
            $partie->setJoueur2($this->utilisateurDao->select($partie->getJoueur2Id()));
            $partie->setJeu($this->jeuDao->select($partie->getJeuId()));
            $parties[] = $partie;
        }

        return $parties;
    }

    private function construirePartie(array $enregistrement): Partie
    {
        return new Partie(
            new DateTime($enregistrement['date_creation']),  // 1. Date
            (int) $enregistrement['j1_id'],                // 2. Joueur 1
            (int) $enregistrement['j2_id'],                // 3. Joueur 2
            (int) $enregistrement['j1_score'],             // 4. Score J1
            (int) $enregistrement['j2_score'],             // 5. Score J2
            (int) $enregistrement['jeu_id'],               // 6. Jeu
            (int) $enregistrement['id']                    // 7. ID
        );
    }
}
