<?php

namespace Dwm\MyGiftBox\application_core\application\usecases;

use Dwm\MyGiftBox\application_core\domain\entities\BoxEntity;

interface BoxServiceInterface
{
    /**
     * Retourne la box associée à l'identifiant.
     * Lève EntityNotFoundException si inconnue.
     */
    public function getBoxById(string $id): BoxEntity;

    /**
     * Retourne la box associée au token public.
     * Lève BoxException::tokenInvalide() si le token ne correspond à aucune box.
     */
    public function getBoxByToken(string $token): BoxEntity;

    /**
     * Génère (ou retourne) le token d'une box :
     *  - la box doit exister (EntityNotFoundException sinon),
     *  - la box doit être dans l'état ACTIF (statut 5) ; lève BoxException::nonUtilisable() sinon,
     *  - si le token existe déjà, il est simplement retourné,
     *  - sinon un nouveau token est généré, persisté et retourné.
     */
    public function genererToken(string $boxId): string;

    /**
     * Retourne la liste des boxes de l'utilisateur identifié par son id.
     *
     * @return BoxEntity[]
     */
    public function getBoxesByUser(string $userId): array;

    public function getBoxes(): array;
}
