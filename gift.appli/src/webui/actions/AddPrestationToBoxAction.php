<?php

namespace Dwm\MyGiftBox\webui\actions;

use Dwm\MyGiftBox\application_core\domain\exceptions\BoxException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Dwm\MyGiftBox\application_core\application\usecases\BoxService;
use Dwm\MyGiftBox\webui\provider\CsrfTokenProvider;


class AddPrestationToBoxAction
{
    public function __construct() {}

    public function __invoke(Request $request, Response $response, array $args)
    {
        $prestationId = $args['id'] ?? null;
        if ($prestationId === null) {
            throw new HttpBadRequestException($request, 'ID de prestation manquant');
        }
        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $csrfToken = $data['csrf_token'] ?? null;
            if (!CsrfTokenProvider::validateToken($csrfToken) || empty($data['presta_id'])) {
                throw new HttpBadRequestException($request, 'Données d ajout de prestation à la box invalides $prestationId : ' . $prestationId);
            }

            try {
                BoxService::addPrestationToBox($prestationId);
            } catch (BoxException $e) {
                throw new HttpInternalServerErrorException($request, 'Erreur lors de l\'ajout de la prestation à la box : ' . $e->getMessage());
            }
        }
        return $response->withHeader('Location', '/boxes')->withStatus(302);
    }
}
