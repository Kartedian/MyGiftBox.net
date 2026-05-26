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

    /**
     * Crée une nouvelle box avec les données fournies, associée à l'utilisateur créateur (optionnel).
     * Lève BoxException en cas de données invalides ou de problème lors de la création.
     * Retourne la box créée sous forme d'entité..
     * 
     * @param string $libelle Le libellé de la box (obligatoire)
     * @param string|null $description La description de la box (optionnelle)
     * @param bool $kdo Indique si la box est un cadeau (true) ou non (false)
     * @param string|null $message_kdo Le message de cadeau associé à la box, si c'est un cadeau (optionnel)
     * @param string|null $createurId L'identifiant de l'utilisateur créateur de la box (optionnel, peut être déterminé à partir du contexte de l'application)
     * @return BoxEntity L'entité représentant la box créée
     * @throws BoxException Si les données sont invalides ou si la création échoue pour une raison quelconque
     */
    public function createBox(string $libelle, ?string $description, bool $kdo, ?string $message_kdo, ?string $createurId): BoxEntity;
}
