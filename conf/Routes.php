<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use myGiftBox\Controllers\CategorieController;

return function (\slim\App $app): \Slim\App {
    $app->get('/categories[/]', CategorieController::class);
    
    return $app;
};

