<?php
namespace Dwm\MyGiftBox\controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Dwm\MyGiftBox\models\Prestation;

class PrestationController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $params = $request->getQueryParams();

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

        $id = $params['id'];
        $prestation = Prestation::find($id);

        if ($prestation === null) {
            $safeId = $id;
            $html = <<<HTML
            <!DOCTYPE html>
            <html>
                <head><title>Prestation introuvable</title></head>
                <body>
                    <h1>Prestation introuvable</h1>
                    <p>Aucune prestation avec l'identifiant {$safeId}.</p>
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
