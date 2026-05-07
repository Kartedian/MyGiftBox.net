<?php
namespace Dwm\MyGiftBox\controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Dwm\MyGiftBox\models\Prestation;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Slim\Exception\HttpNotFoundException;

class PrestationController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $params = $request->getQueryParams()['id'] ?? null;

        if (is_null($params)) {
            throw new HttpBadRequestException($request, 'Le paramètre "id" est requis.');
        }
   if ($params === null) {
        if (!isset($params['id'])) {
            $html = <<<HTML
            <!DOCTYPE html>
            <html>
                <head><title>Erreur</title></head>
                <body>
                    <h1>Paramètre manquant</h1>
                    <p>Le paramètre <code>id</code> est absent de la requête.</p>
                </body>
            </html>
            HTML;
            $response->getBody()->write($html);
            return $response->withStatus(400);
        }
   }

        
        try {
        $prestation = Prestation::findOrFail($params);
        } catch (ModelNotFoundException $e) {
            throw new HttpNotFoundException($request, "Prestation avec id {$params} non trouvée.");
        }
        

        if ($prestation === null) {
            $html = <<<HTML
            <!DOCTYPE html>
            <html>
                <head><title>Prestation introuvable</title></head>
                <body>
                    <h1>Prestation introuvable</h1>
                    <p>Aucune prestation avec l'identifiant {$params}.</p>
                </body>
            </html>
            HTML;
            $response->getBody()->write($html);
            return $response->withStatus(404);
        }

        $libelle = $prestation->libelle;
        $description = $prestation->description;
        $tarif = $prestation->tarif;
        $unite = $prestation->unite;

        $html = <<<HTML
        <!DOCTYPE html>
        <html>
            <head><title>{$libelle}</title></head>
            <body>
                <h1>{$libelle}</h1>
                <p>{$description}</p>
                <p>Tarif : {$tarif} € / {$unite}</p>
            </body>
        </html>
        HTML;

        $response->getBody()->write($html);
        return $response;
    }
}
