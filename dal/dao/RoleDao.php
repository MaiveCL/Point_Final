<?php

class RoleDao extends BaseDao
{
    public function __construct(ConfigDao $config)
    {
        parent::__construct($config);
    }

    public function select(int $id): ?Role
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare("SELECT * FROM role WHERE id=:id");
        $requete->bindValue(":id", $id);
        $requete->execute();

        $role = null;
        if ($enregistrement = $requete->fetch())
        {
            $role = new Role($enregistrement['nom'], $enregistrement['id']);
        }

        return $role;
    }
}
