<?php

namespace Dwm\MyGiftBox\webui\actions;

use Dwm\MyGiftBox\application_core\domain\exceptions\BoxException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Dwm\MyGiftBox\application_core\application\usecases\BoxService;
use Slim\Views\Twig;
use Dwm\MyGiftBox\webui\provider\AuthnProvider;
use Dwm\MyGiftBox\webui\provider\CsrfTokenProvider;

class MesBoxViewAction{

    public function __construct(){}

    public function __invoke(Request $request, Response $response, array $args){

        $UserId = AuthnProvider::getUserId();
        if ($UserId === null) {
            throw new HttpBadRequestException($request, 'ID de user manquant');
        }

        try {
            $boxService = new BoxService();
            $boxUser = $boxService->getBoxesByUser($UserId);
        } catch (BoxException $e) {
            throw new HttpInternalServerErrorException($request, 'Erreur lors de la récupération de la box : ' . $e->getMessage());
        }

        $csrfToken = CsrfTokenProvider::generateToken();
        
        $prestationId = $args['id'] ?? null;
        $view = Twig::fromRequest($request);
        return $view->render($response, 'MesBoxes.html', [
            'boxUser' => $boxUser,
            'prestation_id' => $prestationId,
            'csrf_token' => $csrfToken,

        ]);
     
    }


}