
<?php
// On s'assure que la session est démarrée qu'une seule fois dès que le script est inclus
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

const SEUIL_INACTIVITE = 300; // En secondes (ici 5 minutes -> 300 secondes)

// Avec l’appel de cette fonction, on s’assure de déconnecter l’utilisateur après un temps d'inactivité
mettreAjourTempsActivite();

/**
 * Cette fonction permet de mettre à jour le temps de la dernière activité de l'utilisateur.
 * Si un utilisateur est connecté et que le temps d'inactivité est dépassé, 
 * la session est détruite et l'utilisateur est redirigé vers la page de connexion.
 * Si aucun utilisateur est connecté, elle ne fait rien.
 */
function mettreAjourTempsActivite(): void
{
    if (getUtilisateurConnecte() != null)
    {
        // S'il est connecté, il ne faut pas qu'il ait dépassé le temps d'inactivité
        if (time() - $_SESSION['derniereActivite'] < SEUIL_INACTIVITE)
        {
            // On met à jour le temps de sa dernière activité
            $_SESSION['derniereActivite'] = time();
        }
        // Inactif depuis trop longtemps, on déconnecte et on redirige vers la page de connexion
        else
        {
            detruireSession();
            // Ajustez la page si elle se nomme différemment pour vous...
            header('Location: connexion.phtml');
            exit();
        }
    }
}

/**
 * Cette fonction permet de récupérer l'utilisateur connecté dans $_SESSION. 
 * Renvoie null si aucun utilisateur n'est connecté.
 */
function getUtilisateurConnecte(): ?Utilisateur
{
    // On vérifie si l'utilisateur est connecté en regardant dans $_SESSION
    if (isset($_SESSION['utilisateur']))
    {
        // On retourne l'utilisateur connecté
        return $_SESSION['utilisateur'];
    }

    // On renvoie null si la session ne contient aucun utilisateur
    return null;
}

/**
 * Cette fonction permet de mettre à jour l'utilisateur connecté dans
 * $_SESSION si et seulement si l'utilisateur est DÉJÀ connecté. 
 * L'id de l'utilisateur en session et celui de l'utilisateur passé 
 * en paramètre doivent correspondre.
 */
function setUtilisateurConnecte(Utilisateur $utilisateur): void
{
    if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']->getId() === $utilisateur->getId())
    {
        // On met à jour l'utilisateur connecté dans $_SESSION
        $_SESSION['utilisateur'] = $utilisateur;

        // On met à jour le temps de sa dernière activité
        $_SESSION['derniereActivite'] = time();
    }
}

/**
 * Cette fonction permet de détruire la session.
 * Elle vide la variable $_SESSION et détruit la session côté serveur.
 * Également, elle supprime le cookie côté client.
 */
function detruireSession(): void
{
    // On vide la variable $_SESSION
    $_SESSION = array();

    // On détruit le cookie côté client
    if (ini_get("session.use_cookies"))
    {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 60,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // On détruit complètement la session côté serveur
    session_destroy();
}

$utilisateurConnecte = getUtilisateurConnecte();
