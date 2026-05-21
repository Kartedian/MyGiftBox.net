<?php

use Dwm\MyGiftBox\webui\actions\AccueilAction;
use Dwm\MyGiftBox\webui\actions\BoxDetailAction;
use Dwm\MyGiftBox\webui\actions\BoxTokenAction;
use Dwm\MyGiftBox\webui\actions\CategorieDetailAction;
use Dwm\MyGiftBox\webui\actions\CategorieListeAction;
use Dwm\MyGiftBox\webui\actions\CategoriePrestationListeAction;
use Dwm\MyGiftBox\webui\actions\Coffret_typeDetailAction;
use Dwm\MyGiftBox\webui\actions\Coffret_typeListeAction;
use Dwm\MyGiftBox\webui\actions\PrestationDetailAction;
use Dwm\MyGiftBox\webui\actions\PrestationListeAction;

return function (\Slim\App $app): \Slim\App {
    // Catalogue
    $app->get('[/]', AccueilAction::class)->setName('accueil');
    $app->get('/categories[/]', CategorieListeAction::class)->setName('categories');
    $app->get('/categorie/{id:\d+}[/]', CategorieDetailAction::class)->setName('categorie_detail');
    $app->get('/prestations[/]', PrestationListeAction::class)->setName('prestations');
    $app->get('/prestation/{id}[/]', PrestationDetailAction::class)->setName('prestation_detail');
    $app->get('/categorie/{id:\d+}/prestations[/]', CategoriePrestationListeAction::class)->setName('categ2presta');
    $app->get('/coffret_types[/]', Coffret_typeListeAction::class)->setName('coffret_types');
    $app->get('/coffret_type/{id:\d+}[/]', Coffret_typeDetailAction::class)->setName('coffret_type_detail');

    // Box (Exercice 2 – utilisation d'une box)
    $app->get('/box/{id}/token[/]', BoxTokenAction::class)->setName('box_token');
    $app->get('/box/{token}[/]', BoxDetailAction::class)->setName('box_detail');

    return $app;
};
