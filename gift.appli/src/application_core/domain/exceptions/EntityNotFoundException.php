<?php

namespace Dwm\MyGiftBox\application_core\domain\exceptions;

use RuntimeException;

class EntityNotFoundException extends RuntimeException
{
    public function __construct(string $entityType, string|int $id)
    {
        parent::__construct("Entité '{$entityType}' introuvable pour l'identifiant '{$id}'.");
    }
}
