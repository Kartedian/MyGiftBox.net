<?php

namespace Dwm\MyGiftBox\application_core\domain\entities;

class Coffret_typeEntity
{
    /**
     * @param PrestationEntity[] $prestations
     */
    public function __construct(
        public readonly int             $id,
        public readonly string          $libelle,
        public readonly string          $description,
        public readonly int             $theme_id,
        public readonly ?ThemeEntity    $theme = null,
        public readonly array           $prestations = [],
    ) {}
}
