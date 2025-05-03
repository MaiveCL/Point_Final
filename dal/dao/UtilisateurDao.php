<?php

class UtilisateurDao extends BaseDao
{
    private RoleDao $roleDao;

    public function __construct(ConfigDao $config)
    {
        parent::__construct($config);
        $this->roleDao = new RoleDao($config);
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
}
