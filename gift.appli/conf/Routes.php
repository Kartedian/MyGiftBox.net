<?php

use Dwm\MyGiftBox\controllers\CategoriePrestationListeController;
use Dwm\MyGiftBox\controllers\PrestationDetailController;
use Dwm\MyGiftBox\controllers\PrestationListeController;
use Dwm\MyGiftBox\controllers\CategorieListeController;
use Dwm\MyGiftBox\controllers\CategorieDetailController;
use Dwm\MyGiftBox\controllers\AccueilController;
use Dwm\MyGiftBox\controllers\Coffret_typeListeController;
use Dwm\MyGiftBox\controllers\Coffret_typeDetailController;

return function (\slim\App $app): \Slim\App {
    $app->get('[/]', AccueilController::class)->setName('accueil');
    $app->get('/categories[/]', CategorieListeController::class)->setName('categories');
    $app->get('/categorie/{id}[/]', CategorieDetailController::class)->setName('categorie_detail');
    $app->get('/prestations[/]', PrestationListeController::class)->setName('prestations');
    $app->get('/prestation/{id}[/]', PrestationDetailController::class)->setName('prestation_detail');
    $app->get('/categorie/{id:\d+}/prestations[/]', CategoriePrestationListeController::class)->setName('categ2presta');
    $app->get('/coffret_types[/]', Coffret_typeListeController::class)->setName('coffret_types');
    $app->get('/coffret_type/{id:\d+}[/]', Coffret_typeDetailController::class)->setName('coffret_type_detail');

    return $app;
};
