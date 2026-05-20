<?php
namespace Dwm\MyGiftBox\controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Dwm\MyGiftBox\models\Categorie;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpBadRequestException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Slim\Views\Twig;

class CategorieListeController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $categorie_liste = Categorie::orderBy('id')->get(['id', 'libelle']);

        $view = Twig::fromRequest($request);
        
        return $view->render($response, 'CategorieListeView.html', [
            'categorie_liste' => $categorie_liste,
        ]);
    }
}
