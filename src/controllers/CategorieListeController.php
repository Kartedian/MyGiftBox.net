<?php
namespace Dwm\MyGiftBox\controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Dwm\MyGiftBox\models\Categorie;

class CategorieListeController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $categories = Categorie::orderBy('id')->get(['id', 'libelle']);
        $conf = parse_ini_file(__DIR__ . '/../../conf/conf.ini');
        $BasePath = $conf['BasePath'] ?? '';
        $items = '';
        foreach ($categories as $cat) {
            $id = $cat->id;
            $libelle = $cat->libelle;
            $items .= "<li><a href=\"{$BasePath}/categorie/{$id}\">{$libelle}</a></li>\n";
        }

        $html = <<<HTML
        <!DOCTYPE html>
        <html>
            <head><title>Catégories</title></head>
            <body>
                <h1>Catégories</h1>
                <ul>
                    {$items}
                </ul>
            </body>
        </html>
        HTML;

        $response->getBody()->write($html);
        return $response;
    }
}
