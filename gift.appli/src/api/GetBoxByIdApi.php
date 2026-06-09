<?php

namespace dwm\MyGiftBox\api;

use Dwm\MyGiftBox\application_core\application\usecases\BoxServiceInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class GetBoxByIdApi
{
    public function __construct(private readonly BoxServiceInterface $boxService) {}

    public function __invoke(Request $request, Response $response, array $args): Response
    {
    
        $id = $args['id'] ?? null;
        $box = $this->boxService->getBoxById($id);

        if (!$box) {
            return $response->withStatus(404);
        }

        $payload = json_encode($box);

        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}