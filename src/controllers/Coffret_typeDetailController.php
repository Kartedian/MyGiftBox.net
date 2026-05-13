<?php
namespace Dwm\MyGiftBox\controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Dwm\MyGiftBox\models\Coffret_type;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpBadRequestException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Slim\Views\Twig;

class Coffret_typeDetailController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        if($id === null){
            throw new HttpBadRequestException($request, "Le paramètre 'id' est requis pour accéder à cette ressource.");
        }

        try{
            $coffret_type = Coffret_type::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new HttpInternalServerErrorException($request, "Erreur lors de la récupération du coffret_type avec l'identifiant {$id}.");
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'Coffrets_typeDetailView.html', [
            'id' => $coffret_type->id,
            'libelle' => $coffret_type->libelle,
            'description' => $coffret_type->description,
            'theme_id' => $coffret_type->theme_id,
            'prestations' => $coffret_type->prestations()->get(['id', 'libelle']),
        ]);

    }
}

