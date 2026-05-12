<?php

namespace Dwm\MyGiftBox\controllers;

use Dwm\MyGiftBox\models\Prestation;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class PrestationListeController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $prestation_liste = Prestation::all();
        $conf = parse_ini_file(__DIR__ . '/../../conf/conf.ini');
        $basepath = $conf['BasePath'] ?? '';

        $view = Twig::fromRequest($request);

        return $view->render($response, 'PrestationListeView.html', [
            'prestation_liste' => $prestation_liste,
            'basepath' => $basepath
        ]);
    }
}