<?php

namespace Dwm\MyGiftBox\controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Dwm\MyGiftBox\models\Prestation;
use Dwm\MyGiftBox\models\Categorie;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpBadRequestException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;


class CategoriePrestationListeController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        if($id === null){
            throw new HttpBadRequestException($request, "Le paramètre 'id' est requis pour accéder à cette ressource.");
        }

        try{
            $categorie = Categorie::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new HttpInternalServerErrorException($request, "Erreur lors de la récupération de la catégorie avec l'identifiant {$id}.");
        }

        try{
            $prestation_liste = Prestation::query()->where('cat_id', $id)->get(['id', 'libelle']);
        } catch (ModelNotFoundException $e){
            throw new HttpInternalServerErrorException($request, "Erreur lors de la récupération la liste des prestations.");
        }

        $view = Twig::fromRequest($request);

        return $view->render($response, 'CategoriePrestationListeView.html', [
            'id' => $id,
            'libelle' => $categorie->libelle,
            'prestation_liste' => $prestation_liste
        ]);
    }
}