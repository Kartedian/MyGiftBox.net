<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Dwm\MyGiftBox\controllers\CategorieListeController;
use Dwm\MyGiftBox\controllers\CategorieDetailController;
use Dwm\MyGiftBox\controllers\PrestationController;
use Dwm\MyGiftBox\controllers\AccueilController;

return function (\slim\App $app): \Slim\App {
    $app->get('[/]', AccueilController::class)->setName('accueil');
    $app->get('/categories[/]', CategorieListeController::class)->setName('categories');
    $app->get('/categorie/{id}[/]', CategorieDetailController::class)->setName('categorie');
    $app->get('/prestation[/]', PrestationController::class)->setName('prestation');

    return $app;
};
