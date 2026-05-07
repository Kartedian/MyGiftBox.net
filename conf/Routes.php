<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Dwm\MyGiftBox\controllers\CategorieListeController;
use Dwm\MyGiftBox\controllers\CategorieDetailController;
use Dwm\MyGiftBox\controllers\PrestationController;

return function (\slim\App $app): \Slim\App {
    $app->get('/categories[/]', CategorieListeController::class);
    $app->get('/categorie/{id}[/]', CategorieDetailController::class);
    $app->get('/prestation[/]', PrestationController::class);

    return $app;
};

