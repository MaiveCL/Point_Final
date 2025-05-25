<?php

class UtilisateurDao extends BaseDao
{
    private RoleDao $roleDao;

    public function __construct(ConfigDao $config)
    {
        parent::__construct($config);
        $this->roleDao = new RoleDao($config);
    }

    // ***** MA FONCTION pour compte les utilisateurs (donc joueurs inscrits) *****
    // pour + de performances, on utilise query() plutôt que prepare(), car pas besoin de execute() et bindValue() car il n'y a pas de variables provenant de l'utilisateur
    public function compterJoueurs(): int {
        $connexion = $this->getConnexion();
        $requete = $connexion->query("SELECT COUNT(*) FROM utilisateur");
        return (int) $requete->fetchColumn();
    }

    public function select(int $id): ?Utilisateur
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare("SELECT * FROM utilisateur WHERE id=:id");
        $requete->bindValue(":id", $id);
        $requete->execute();

        $utilisateur = null;
        if ($enregistrement = $requete->fetch())
        {
            $utilisateur = $this->construireUtilisateur($enregistrement);
            $utilisateur->setRole($this->roleDao->select($utilisateur->getRoleId()));
        }

        return $utilisateur;
    }

    public function selectParNomUtilisateur(string $nomUtilisateur): ?Utilisateur
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare("SELECT * FROM utilisateur WHERE nom_utilisateur=:nom_utilisateur");
        $requete->bindValue(":nom_utilisateur", $nomUtilisateur);
        $requete->execute();

        $utilisateur = null;
        if ($enregistrement = $requete->fetch())
        {
            $utilisateur = $this->construireUtilisateur($enregistrement);
            $utilisateur->setRole($this->roleDao->select($utilisateur->getRoleId()));
        }

        return $utilisateur;
    }

    private function construireUtilisateur($enregistrement): ?Utilisateur
    {
        return new Utilisateur(
            $enregistrement['nom_utilisateur'],
            $enregistrement['prenom'],
            $enregistrement['nom'],
            $enregistrement['bio'],
            new DateTime($enregistrement['date_creation']),
            $enregistrement['role_id'],
            $enregistrement['url_avatar'],
            $enregistrement['hash'],
            $enregistrement['id']
        );
    }

    public function insert(Utilisateur $utilisateur): void
    {
        $connexion = $this->getConnexion();

        $sql = "INSERT INTO utilisateur (
                    nom_utilisateur, prenom, nom, bio, date_creation,
                    role_id, url_avatar, hash
                ) VALUES (
                    :nom_utilisateur, :prenom, :nom, :bio, :date_creation,
                    :role_id, :url_avatar, :hash
                )";

        $requete = $connexion->prepare($sql);
        $requete->bindValue(':nom_utilisateur', $utilisateur->getNomUtilisateur());
        $requete->bindValue(':prenom', $utilisateur->getPrenom());
        $requete->bindValue(':nom', $utilisateur->getNom());
        $requete->bindValue(':bio', $utilisateur->getBio());
        $requete->bindValue(':date_creation', $utilisateur->getDateCreation()->format('Y-m-d'));
        $requete->bindValue(':role_id', $utilisateur->getRoleId());
        $requete->bindValue(':url_avatar', $utilisateur->getUrlAvatar());
        $requete->bindValue(':hash', $utilisateur->getHash());
        $requete->execute();

        // On met à jour l'ID généré automatiquement dans l'objet
        $utilisateur->setId((int) $connexion->lastInsertId());
    }

    public function updateInfos(Utilisateur $utilisateur): void
    {
        $connexion = $this->getConnexion();
        $sql = "
            UPDATE utilisateur
            SET prenom = :prenom,
                nom = :nom,
                bio = :bio,
                url_avatar = :avatar
            WHERE id = :id
        ";
        $requete = $connexion->prepare($sql);
        $requete->bindValue(':prenom', $utilisateur->getPrenom());
        $requete->bindValue(':nom', $utilisateur->getNom());
        $requete->bindValue(':bio', $utilisateur->getBio());
        $requete->bindValue(':avatar', $utilisateur->getUrlAvatar());
        $requete->bindValue(':id', $utilisateur->getId());
        $requete->execute();
    }

}
