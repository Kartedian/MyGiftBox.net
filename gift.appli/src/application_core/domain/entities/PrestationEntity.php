<?php

namespace Dwm\MyGiftBox\application_core\domain\entities;

class PrestationEntity
{
    public function __construct(
        public readonly string  $id,
        public readonly string  $libelle,
        public readonly string  $description,
        public readonly ?string $url,
        public readonly ?string $unite,
        public readonly float   $tarif,
        public readonly string  $img,
        public readonly int     $cat_id,
    ) {}
}
