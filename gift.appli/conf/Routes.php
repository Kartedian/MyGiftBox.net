<?php

use Dwm\MyGiftBox\webui\actions\AccueilAction;
use Dwm\MyGiftBox\webui\actions\BoxCreerAction;
use Dwm\MyGiftBox\webui\actions\BoxDetailAction;
use Dwm\MyGiftBox\webui\actions\BoxTokenAction;
use Dwm\MyGiftBox\webui\actions\CategorieDetailAction;
use Dwm\MyGiftBox\webui\actions\CategorieListeAction;
use Dwm\MyGiftBox\webui\actions\CategoriePrestationListeAction;
use Dwm\MyGiftBox\webui\actions\Coffret_typeDetailAction;
use Dwm\MyGiftBox\webui\actions\Coffret_typeListeAction;
use Dwm\MyGiftBox\webui\actions\ListboxviewxAction;
use Dwm\MyGiftBox\webui\actions\PrestationDetailAction;
use Dwm\MyGiftBox\webui\actions\PrestationListeAction;
use Dwm\MyGiftBox\webui\actions\BoxListeAction;
use Dwm\MyGiftBox\webui\actions\LoginAction;
use Dwm\MyGiftBox\webui\actions\RegisterAction;
use Dwm\MyGiftBox\api\GetPrestationByCoffretApi;
use Dwm\MyGiftBox\webui\actions\LogoutAction;
use Dwm\MyGiftBox\api\GetPrestationApi;
use Dwm\MyGiftBox\api\GetCategoriesApi;
use Dwm\MyGiftBox\api\GetPrestationByCategoriesApi;
use Dwm\MyGiftBox\api\GetBoxByIdApi;

return function (\Slim\App $app): \Slim\App {
    // Authentification
    $app->get('/register[/]', RegisterAction::class)->setName('register');
    $app->post('/register[/]', RegisterAction::class);
    $app->get('/login[/]', LoginAction::class)->setName('login');
    $app->post('/login[/]', LoginAction::class);
    $app->get('/logout[/]', LogoutAction::class)->setName('logout');


    // Catalogue
    $app->get('[/]', AccueilAction::class)->setName('accueil');
    $app->get('/categories[/]', CategorieListeAction::class)->setName('categories');
    $app->get('/categorie/{id:\d+}[/]', CategorieDetailAction::class)->setName('categorie_detail');
    $app->get('/prestations[/]', PrestationListeAction::class)->setName('prestations');
    $app->get('/prestation/{id}[/]', PrestationDetailAction::class)->setName('prestation_detail');
    $app->get('/categorie/{id:\d+}/prestations[/]', CategoriePrestationListeAction::class)->setName('categ2presta');
    $app->get('/coffret_types[/]', Coffret_typeListeAction::class)->setName('coffret_types');
    $app->get('/coffret_type/{id:\d+}[/]', Coffret_typeDetailAction::class)->setName('coffret_type_detail');
    $app->get('/listboxviewx[/]', ListboxviewxAction::class)->setName('listboxviewx');

    // Box (Exercice 2 – utilisation d'une box)
    $app->get('/boxes[/]', BoxListeAction::class)->setName('boxes');
    $app->get('/box/{id}/token[/]', BoxTokenAction::class)->setName('boxe_token');
    $app->get('/box/detail[/]', BoxDetailAction::class)->setName('boxe_detail');
    $app->get('/box/create[/]', BoxCreerAction::class)->setName('boxe_create');

    // API
    $app->get('/api/prestations', GetPrestationApi::class)->setName('api_prestations');
    $app->get('/api/coffrets/{id}/prestations', GetPrestationByCoffretApi::class)->setName('api_coffret_prestations');
    $app->get('/api/categories', GetCategoriesApi::class)->setName('api_categories');
    $app->get('/api/categories/{id}/prestations', GetPrestationByCategoriesApi::class)->setName('api_categories_prestations');
    $app->get('/api/box/{id}', GetBoxByIdApi::class)->setName('api_box_by_id');
    
    //POST
    $app->post('/box/create[/]', BoxCreerAction::class);

    return $app;
};
