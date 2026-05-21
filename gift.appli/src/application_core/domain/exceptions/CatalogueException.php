<?php

namespace Dwm\MyGiftBox\application_core\domain\exceptions;

use RuntimeException;

class CatalogueException extends RuntimeException
{
    public static function erreurRecuperation(string $message): self
    {
        return new self("Erreur catalogue : {$message}");
    }
}
