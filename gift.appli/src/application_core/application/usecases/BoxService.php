<?php

namespace Dwm\MyGiftBox\application_core\application\usecases;

use Dwm\MyGiftBox\application_core\domain\entities\BoxEntity;
use Dwm\MyGiftBox\application_core\domain\entities\PrestationEntity;
use Dwm\MyGiftBox\application_core\domain\exceptions\BoxException;
use Dwm\MyGiftBox\application_core\domain\exceptions\EntityNotFoundException;
use Dwm\MyGiftBox\infrastructure\Box;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class BoxService implements BoxServiceInterface
{
    public function getBoxById(string $id): BoxEntity
    {
        try {
            $box = Box::with('prestations')->findOrFail($id);
        } catch (ModelNotFoundException) {
            throw new EntityNotFoundException('Box', $id);
        } catch (Throwable $e) {
            throw new \RuntimeException("Erreur lors de la récupération de la box {$id} : {$e->getMessage()}", 0, $e);
        }

        return $this->toEntity($box);
    }

    public function getBoxByToken(string $token): BoxEntity
    {
        try {
            $box = Box::with('prestations')->where('token', $token)->first();
        } catch (Throwable $e) {
            throw new \RuntimeException("Erreur lors de la recherche par token : {$e->getMessage()}", 0, $e);
        }

        if ($box === null) {
            throw BoxException::tokenInvalide();
        }

        if (!$this->toEntity($box)->isUtilisable()) {
            throw BoxException::nonUtilisable($box->id);
        }

        return $this->toEntity($box);
    }

    public function genererToken(?string $boxId): string
    {
        if ($boxId !== null) {
            try {
                $box = Box::findOrFail($boxId);
            } catch (ModelNotFoundException) {
                throw new EntityNotFoundException('Box', $boxId);
            } catch (Throwable $e) {
                throw new \RuntimeException("Erreur lors de la récupération de la box {$boxId} : {$e->getMessage()}", 0, $e);
            }

            if ($box->statut !== Box::STATUT_ACTIF) {
                throw BoxException::nonUtilisable($boxId);
            }

            return $box->token;
        } else {
            do {
                $token = base64_encode(random_bytes(32));
            }while(Box::with('prestations')->where('token', $token)->first() !== null);
        }
        return $token;
    }

    public function getBoxesByUser(string $userId): array
    {
        try {
            return Box::with('prestations')
                ->where('createur_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn($b) => $this->toEntity($b))
                ->all();
        } catch (Throwable $e) {
            throw new \RuntimeException("Erreur lors de la récupération des boxes de l'utilisateur {$userId} : {$e->getMessage()}", 0, $e);
        }
    }


    // TODO: Vérrifier la lib elloquante + ajout verif uid
    private function generateUuidV4(): string
    {
        $data = random_bytes(16);
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
    
        $hex = bin2hex($data);
    
        return sprintf(
            '%s-%s-%s-%s-%s',
            substr($hex, 0, 8),
            substr($hex, 8, 4),
            substr($hex, 12, 4),
            substr($hex, 16, 4),
            substr($hex, 20, 12)
        );
    }

    public function createBox(string $libelle, ?string $description, bool $kdo, ?string $message_kdo, ?string $createurId): BoxEntity
    {
        try {
            $id = $this->generateUuidV4();
            $token = $this->genererToken(null);

            $now = date('Y-m-d H:i:s');

            $box = Box::create([
                'id' => $id,
                'token' => $token,
                'libelle' => $libelle,
                'description' => $description,
                'kdo' => $kdo,
                'message_kdo' => $message_kdo,
                'statut' => Box::STATUT_BROUILLON,
                'created_at' => $now,
                'createur_id' => $createurId,
            ]);
        } catch (Throwable $e) {
            throw new \RuntimeException("Erreur lors de la création de la box : {$e->getMessage()}", 0, $e);
        }

        return $this->toEntity($box);
    }

    // -------------------------------------------------------------------------

    private function toEntity(Box $box): BoxEntity
    {
        $prestations = $box->relationLoaded('prestations')
            ? $box->prestations->map(fn($p) => [
                'presta' => new PrestationEntity(
                    $p->id,
                    $p->libelle,
                    $p->description,
                    $p->url,
                    $p->unite,
                    (float) $p->tarif,
                    $p->img,
                    $p->cat_id,
                ),
                'quantite' => $p->pivot->quantite,
            ])->all()
            : [];

        return new BoxEntity(
            id:          $box->id,
            token:       $box->token,
            libelle:     $box->libelle,
            description: $box->description,
            montant:     (float) $box->montant,
            kdo:         (bool) $box->kdo,
            message_kdo: $box->message_kdo,
            statut:      $box->statut,
            created_at:  $box->created_at,
            createur_id: $box->createur_id,
            prestations: $prestations,
        );
    }

    public function getBoxes(): array
    {
        try{
            return Box::orderBy('id')->get()->map(fn($box) => new BoxEntity(
                id:          $box->id,
                token:       $box->token,
                libelle:     $box->libelle,
                description: $box->description,
                montant:     (float) $box->montant,
                kdo:         (bool) $box->kdo,
                message_kdo: $box->message_kdo,
                statut:      $box->statut,
                created_at:  $box->created_at,
                createur_id: $box->createur_id,
                prestations: [],
            ))->all();
        }
        catch (Throwable $e){
            throw BoxException::erreurRecuperation("impossible de charger la liste des boxes : {$e->getMessage()}");
        }
    }
}
