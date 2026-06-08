<?php

namespace Dwm\MyGiftBox\application_core\application\usecases;

use Dwm\MyGiftBox\application_core\domain\entities\CategorieEntity;
use Dwm\MyGiftBox\application_core\domain\entities\Coffret_typeEntity;
use Dwm\MyGiftBox\application_core\domain\entities\PrestationEntity;
use Dwm\MyGiftBox\application_core\domain\entities\ThemeEntity;
use Dwm\MyGiftBox\application_core\domain\exceptions\CatalogueException;
use Dwm\MyGiftBox\application_core\domain\exceptions\EntityNotFoundException;
use Dwm\MyGiftBox\infrastructure\Categorie;
use Dwm\MyGiftBox\infrastructure\Coffret_type;
use Dwm\MyGiftBox\infrastructure\Prestation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class CatalogueService implements CatalogueServiceInterface
{
    public function getCategories(): array
    {
        try {
            return Categorie::orderBy('id')
                ->get()
                ->map(fn($c) => new CategorieEntity($c->id, $c->libelle, $c->description))
                ->all();
        } catch (Throwable $e) {
            throw CatalogueException::erreurRecuperation("impossible de charger la liste des catégories : {$e->getMessage()}");
        }
    }

    public function getCategorieById(int $id): array
    {
        try {
            $c = Categorie::findOrFail($id);
        } catch (ModelNotFoundException) {
            throw new EntityNotFoundException('Categorie', $id);
        } catch (Throwable $e) {
            throw CatalogueException::erreurRecuperation("erreur lors de la récupération de la catégorie {$id} : {$e->getMessage()}");
        }

        return [
            'id'          => $c->id,
            'libelle'     => $c->libelle,
            'description' => $c->description,
        ];
    }

    public function getPrestationById(string $id): array
    {
        try {
            $p = Prestation::findOrFail($id);
        } catch (ModelNotFoundException) {
            throw new EntityNotFoundException('Prestation', $id);
        } catch (Throwable $e) {
            throw CatalogueException::erreurRecuperation("erreur lors de la récupération de la prestation {$id} : {$e->getMessage()}");
        }

        return [
            'id'          => $p->id,
            'libelle'     => $p->libelle,
            'description' => $p->description,
            'url'         => $p->url,
            'unite'       => $p->unite,
            'tarif'       => $p->tarif,
            'img'         => $p->img,
            'cat_id'      => $p->cat_id,
        ];
    }

    public function getPrestationsByCategorie(int $categ_id): array
    {
        try {
            Categorie::findOrFail($categ_id);
        } catch (ModelNotFoundException) {
            throw new EntityNotFoundException('Categorie', $categ_id);
        }

        try {
            return Prestation::where('cat_id', $categ_id)
                ->get()
                ->map(fn($p) => new PrestationEntity(
                    $p->id,
                    $p->libelle,
                    $p->description,
                    $p->url,
                    $p->unite,
                    (float) $p->tarif,
                    $p->img,
                    $p->cat_id,
                ))
                ->all();
        } catch (Throwable $e) {
            throw CatalogueException::erreurRecuperation("erreur lors de la récupération des prestations de la catégorie {$categ_id} : {$e->getMessage()}");
        }
    }

    public function getThemesCoffrets(): array
    {
        try {
            return Coffret_type::with('theme')
                ->orderBy('id')
                ->get()
                ->map(function ($ct) {
                    $theme = $ct->theme
                        ? new ThemeEntity($ct->theme->id, $ct->theme->libelle, $ct->theme->description)
                        : null;

                    return new Coffret_typeEntity(
                        $ct->id,
                        $ct->libelle,
                        $ct->description,
                        $ct->theme_id,
                        $theme,
                    );
                })
                ->all();
        } catch (Throwable $e) {
            throw CatalogueException::erreurRecuperation("impossible de charger les coffrets-types : {$e->getMessage()}");
        }
    }

    public function getCoffretById(int $id): array
    {
        try {
            $ct = Coffret_type::with(['theme', 'prestations'])->findOrFail($id);
        } catch (ModelNotFoundException) {
            throw new EntityNotFoundException('Coffret_type', $id);
        } catch (Throwable $e) {
            throw CatalogueException::erreurRecuperation("erreur lors de la récupération du coffret-type {$id} : {$e->getMessage()}");
        }

        return [
            'id'          => $ct->id,
            'libelle'     => $ct->libelle,
            'description' => $ct->description,
            'theme_id'    => $ct->theme_id,
            'prestations' => $ct->prestations->map(fn($p) => [
                'id'      => $p->id,
                'libelle' => $p->libelle,
            ])->all(),
        ];
    }

    public function getPrestationsByCoffretId(int $id):array{
        try{
            $coffretType = Coffret_type::find($id);
        }catch (ModelNotFoundException $e){
            throw new EntityNotFoundException('Coffret_type', $id);
        }catch (Throwable $e) {
            throw CatalogueException::erreurRecuperation("erreur lors de la recuperation du coffret-type {$id}: {$e->getMessage()}");
        }
        
        return $coffretType->prestations->toArray();
    }

    public function getPrestations(): array
    {
        try {
            return Prestation::orderBy('id')
                ->get()
                ->map(fn($p) => new PrestationEntity(
                    $p->id,
                    $p->libelle,
                    $p->description,
                    $p->url,
                    $p->unite,
                    (float) $p->tarif,
                    $p->img,
                    $p->cat_id,
                ))
                ->all();
        } catch (Throwable $e) {
            throw CatalogueException::erreurRecuperation("impossible de charger la liste des prestations : {$e->getMessage()}");
        }
    }
}
