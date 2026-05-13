<?php
namespace Dwm\MyGiftBox\controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Dwm\MyGiftBox\models\Coffret_type;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpBadRequestException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Slim\Views\Twig;

class Coffret_typeListeController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $coffret_type_liste = Coffret_type::orderBy('id')->get(['id', 'libelle']);
        $conf = parse_ini_file(__DIR__ . '/../../conf/conf.ini');
        $basepath = $conf['BasePath'] ?? '';

        $view = Twig::fromRequest($request);
        
        return $view->render($response, 'Coffret_typeListeView.html', [
            'coffret_type_liste' => $coffret_type_liste,
            'basepath' => $basepath,
        ]);
    }
}
