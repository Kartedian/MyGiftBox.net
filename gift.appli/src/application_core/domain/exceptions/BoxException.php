<?php

namespace Dwm\MyGiftBox\application_core\domain\exceptions;

use RuntimeException;

class BoxException extends RuntimeException
{
    public static function nonUtilisable(string $boxId): self
    {
        return new self("La box '{$boxId}' n'est pas dans un état permettant son utilisation.");
    }

    public static function tokenInvalide(): self
    {
        return new self("Le token fourni est invalide ou ne correspond à aucune box.");
    }

    public static function erreurRecuperation(string $message)
    {
        return new self("Erreur box : {$message}");
    }

    public static function brouillonIntrouvable(string $boxId): self
    {
        return new self("Aucune box au statut 'brouillon' trouvée avec l'ID '{$boxId}'.");
    }
}
