<?php

namespace Dwm\MyGiftBox\controllers;

use Dwm\MyGiftBox\models\Prestation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Views\Twig;

class PrestationDetailController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        if($id === null){
            throw new HttpBadRequestException($request, "Le parametre 'id' est requis pour acceder a cette ressource.");
        }

        try{
            $prestation = Prestation::findOrFail($id);
        } catch (ModelNotFoundException $e){
            throw new HttpBadRequestException($request, "Erreur lors de la recuperation de la prestation avec l'identifiant {$id}");
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'PrestationDetailView.html', [
            'id'=>$prestation->id,
            'libelle'=>$prestation->libelle,
            'description'=>$prestation->description,
            'url'=>$prestation->url ?? ('null'),
            'unite'=>$prestation->unite,
            'tarif'=>$prestation->tarif,
        ]);
    }
}