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
            new DateTime($enregistrement['date_creation']),
            (int) $enregistrement['j1_id'],
            (int) $enregistrement['j2_id'],
            (int) $enregistrement['j1_score'],
            (int) $enregistrement['j2_score'],
            (int) $enregistrement['jeu_id'],
            (int) $enregistrement['id']
        );
    }

    public function insert(Partie $partie): void
    {
        $connexion = $this->getConnexion();

        $sql = "INSERT INTO partie (
                    date_creation,
                    j1_id,
                    j2_id,
                    j1_score,
                    j2_score,
                    jeu_id
                ) VALUES (
                    NOW(), :j1_id, :j2_id, :j1_score, :j2_score, :jeu_id
                )";

        $requete = $connexion->prepare($sql);
        $requete->bindValue(':j1_id', $partie->getJoueur1Id(), PDO::PARAM_INT);
        $requete->bindValue(':j2_id', $partie->getJoueur2Id(), PDO::PARAM_INT);
        $requete->bindValue(':j1_score', $partie->getScoreJoueur1(), PDO::PARAM_INT);
        $requete->bindValue(':j2_score', $partie->getScoreJoueur2(), PDO::PARAM_INT);
        $requete->bindValue(':jeu_id', $partie->getJeuId(), PDO::PARAM_INT);
        $requete->execute();

        $partie->setId((int) $connexion->lastInsertId());
    }

}
