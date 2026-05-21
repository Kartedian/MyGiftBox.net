<?php

namespace Dwm\MyGiftBox\application_core\application\usecases;

interface CatalogueServiceInterface
{
    /** @return array<\Dwm\MyGiftBox\application_core\domain\entities\CategorieEntity> */
    public function getCategories(): array;

    /** @return array<string, mixed> */
    public function getCategorieById(int $id): array;

    /** @return array<string, mixed> */
    public function getPrestationById(string $id): array;

    /** @return array<\Dwm\MyGiftBox\application_core\domain\entities\PrestationEntity> */
    public function getPrestationsByCategorie(int $categ_id): array;

    /** @return array<\Dwm\MyGiftBox\application_core\domain\entities\Coffret_typeEntity> */
    public function getThemesCoffrets(): array;

    /** @return array<string, mixed> */
    public function getCoffretById(int $id): array;
}
