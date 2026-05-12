<?php
namespace Dwm\MyGiftBox\controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class AccueilController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'accueil.twig');
    }
}
