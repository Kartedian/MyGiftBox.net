<?php
namespace Dwm\MyGiftBox\controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Dwm\MyGiftBox\models\Categorie;

class CategorieDetailController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $categorie = Categorie::find($id);

        if ($categorie === null) {
            $html = <<<HTML
            <!DOCTYPE html>
            <html>
                <head><title>Catégorie introuvable</title></head>
                <body>
                    <h1>Catégorie introuvable</h1>
                    <p>Aucune catégorie avec l'identifiant {$id}.</p>
                </body>
            </html>
            HTML;
            $response->getBody()->write($html);
            return $response->withStatus(404);
        }

        $libelle = $categorie->libelle;
        $description = $categorie->description;

        $html = <<<HTML
        <!DOCTYPE html>
        <html>
            <head><title>{$libelle}</title></head>
            <body>
                <h1>{$libelle}</h1>
                <p>{$description}</p>
            </body>
        </html>
        HTML;

        $response->getBody()->write($html);
        return $response;
    }
}
