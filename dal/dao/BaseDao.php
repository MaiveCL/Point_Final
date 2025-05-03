<?php

/**
 * Classe abstraite parent pour tous les DAO liés à une BD.
 * Un DAO se spécialise dans les opérations sur une table.
 */
abstract class BaseDao
{
    private ConfigDao $config;
    private ?PDO $connexion;

    public function __construct(ConfigDao $config)
    {
        $this->config = $config;
        $this->connexion = null;
    }

    /**
     * Retourne la connexion à la BD du DAO. L'appelant n'a pas à fermer la connexion.
     * 
     * @return PDO La connexion à la BD.
     * @throws PDOException S'il y a une erreur de connexion.
     */
    protected function getConnexion(): PDO
    {
        if ($this->connexion === null)
        {
            $this->connexion = new PDO(
                $this->config->creerChaineConnexion(),
                $this->config->getNomUtilisateur(),
                $this->config->getMotDePasse(),
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_FOUND_ROWS => true
                )
            );
        }

        return $this->connexion;
    }

    protected function getConfig(): ConfigDao
    {
        return $this->config;
    }

    /**
     * Destructeur. Ferme la connexion à la BD.
     */
    function __destruct()
    {
        $this->connexion = null;
    }
}
