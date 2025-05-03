<?php

class StatistiqueDao extends BaseDao
{
    public function __construct(ConfigDao $config)
    {
        parent::__construct($config);
    }

    /**
     * Permet d'obtenir le classement global des joueurs.
     * 
     * @return array Un tableau d'objets ResultatClassementGlobal contenant les statistiques de chaque joueur (du meilleur au moins bon).
     */
    public function selectClassementGlobal(): array
    {
        $connexion = $this->getConnexion();

        // Score total => Victoire =  3 points, Égalité = 1 point, Défaite = 0 point
        $sql = "
                SELECT 
                    u.id AS joueur_id,
                    u.nom, 
                    u.prenom,
                    COALESCE(SUM(CASE WHEN p.j1_id = u.id AND p.j1_score > p.j2_score THEN 1
                                    WHEN p.j2_id = u.id AND p.j2_score > p.j1_score THEN 1
                                ELSE 0 END), 0) AS parties_gagnees,
                    COALESCE(SUM(CASE WHEN p.j1_id = u.id AND p.j1_score < p.j2_score THEN 1
                                    WHEN p.j2_id = u.id AND p.j2_score < p.j1_score THEN 1
                                ELSE 0 END), 0) AS parties_perdues,
                    COALESCE(SUM(CASE WHEN p.j1_score = p.j2_score THEN 1 ELSE 0 END), 0) AS parties_egales,
                    (COALESCE(SUM(CASE WHEN p.j1_id = u.id AND p.j1_score > p.j2_score THEN 1
                                    WHEN p.j2_id = u.id AND p.j2_score > p.j1_score THEN 1
                                ELSE 0 END), 0) * 3) 
                    +
                    (COALESCE(SUM(CASE WHEN p.j1_score = p.j2_score THEN 1 ELSE 0 END), 0) * 1) 
                    AS score_total,
                    COALESCE(COUNT(p.id), 0) AS nb_parties
                FROM utilisateur u
                LEFT JOIN partie p ON u.id = p.j1_id OR u.id = p.j2_id
                WHERE u.role_id = 2
                GROUP BY u.id, u.nom, u.prenom
                ORDER BY score_total DESC, nb_parties ASC;
                ";

        $requete = $connexion->prepare($sql);
        $requete->execute();

        $resultats = [];
        while ($enregistrement = $requete->fetch())
        {
            $resultats[] = new ResultatClassementGlobal(
                $enregistrement["joueur_id"],
                $enregistrement["prenom"] . ' ' . $enregistrement["nom"],
                $enregistrement["parties_gagnees"],
                $enregistrement["parties_perdues"],
                $enregistrement["parties_egales"],
                $enregistrement["nb_parties"],
                $enregistrement["score_total"]
            );
        }

        return $resultats;
    }


    /**
     * Permet d'obtenir les statistiques d'un joueur spécifique.    
     * 
     * @param int $joueurId L'identifiant du joueur.
     * 
     * @return ResultatClassementGlobal|null Un objet ResultatClassementGlobal contenant les statistiques du joueur, ou null si le joueur n'existe pas.
     */
    public function selectClassementGlobalParJoueur(int $joueurId): ?ResultatClassementGlobal
    {
        $connexion = $this->getConnexion();

        // Score total => Victoire =  3 points, Égalité = 1 point, Défaite = 0 point
        $sql = "
                SELECT 
                    u.id AS joueur_id,
                    u.nom, 
                    u.prenom,
                    COALESCE(SUM(CASE WHEN p.j1_id = u.id AND p.j1_score > p.j2_score THEN 1
                                    WHEN p.j2_id = u.id AND p.j2_score > p.j1_score THEN 1
                                ELSE 0 END), 0) AS parties_gagnees,
                    COALESCE(SUM(CASE WHEN p.j1_id = u.id AND p.j1_score < p.j2_score THEN 1
                                    WHEN p.j2_id = u.id AND p.j2_score < p.j1_score THEN 1
                                ELSE 0 END), 0) AS parties_perdues,
                    COALESCE(SUM(CASE WHEN p.j1_score = p.j2_score THEN 1 ELSE 0 END), 0) AS parties_egales,
                    (COALESCE(SUM(CASE WHEN p.j1_id = u.id AND p.j1_score > p.j2_score THEN 1
                                    WHEN p.j2_id = u.id AND p.j2_score > p.j1_score THEN 1
                                ELSE 0 END), 0) * 3) 
                    +
                    (COALESCE(SUM(CASE WHEN p.j1_score = p.j2_score THEN 1 ELSE 0 END), 0) * 1) 
                    AS score_total,
                    COALESCE(COUNT(p.id), 0) AS nb_parties
                FROM utilisateur u
                LEFT JOIN partie p ON u.id = p.j1_id OR u.id = p.j2_id
                WHERE u.id = :joueur_id
                GROUP BY u.id, u.nom, u.prenom
                ORDER BY score_total DESC, nb_parties ASC;
                ";

        $requete = $connexion->prepare($sql);
        $requete->bindValue(":joueur_id", $joueurId, PDO::PARAM_INT);
        $requete->execute();

        $resultat = null;
        if ($enregistrement = $requete->fetch())
        {
            $resultat = new ResultatClassementGlobal(
                $enregistrement["joueur_id"],
                $enregistrement["prenom"] . ' ' . $enregistrement["nom"],
                $enregistrement["parties_gagnees"],
                $enregistrement["parties_perdues"],
                $enregistrement["parties_egales"],
                $enregistrement["nb_parties"],
                $enregistrement["score_total"]
            );
        }

        return $resultat;
    }
}
