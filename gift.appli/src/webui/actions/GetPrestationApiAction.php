<?php

namespace Dwm\MyGiftBox\webui\actions;
use Dwm\MyGiftBox\application_core\application\usecases\CatalogueServiceInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class GetPrestationApiAction
{
    public function __construct(private readonly CatalogueServiceInterface $catalogue)
    {
    }

    public function __invoke(Request $request, Response $response, array $args):Response{
        $coffretId = (int) $args['id'];

        $prestaions = $this->catalogue->getPrestationsByCoffretId($coffretId);

        $payload = json_encode($prestaions);

        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type','application/json')->withStatus(200);
    }
}