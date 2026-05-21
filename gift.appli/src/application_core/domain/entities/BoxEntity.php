<?php

namespace Dwm\MyGiftBox\application_core\domain\entities;

class BoxEntity
{
    public const STATUT_BROUILLON  = 1;
    public const STATUT_EN_ATTENTE = 2;
    public const STATUT_PAYE       = 3;
    public const STATUT_VALIDE     = 4;
    public const STATUT_ACTIF      = 5;

    /**
     * @param array<array{presta: PrestationEntity, quantite: int}> $prestations
     */
    public function __construct(
        public readonly string   $id,
        public readonly string   $token,
        public readonly string   $libelle,
        public readonly ?string  $description,
        public readonly float    $montant,
        public readonly bool     $kdo,
        public readonly ?string  $message_kdo,
        public readonly int      $statut,
        public readonly string   $created_at,
        public readonly ?string  $createur_id,
        public readonly array    $prestations = [],
    ) {}

    public function isUtilisable(): bool
    {
        return $this->statut === self::STATUT_ACTIF;
    }
}
