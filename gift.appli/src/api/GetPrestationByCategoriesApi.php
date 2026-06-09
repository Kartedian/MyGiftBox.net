<?php

namespace dwm\MyGiftBox\api;

use Dwm\MyGiftBox\application_core\application\usecases\CatalogueServiceInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class GetPrestationByCategoriesApi
{
    public function __construct(private readonly CatalogueServiceInterface $catalogue) {}

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $categoryId = (int) $args['id'];

        $prestaions = $this->catalogue->getPrestationsByCategoryId($categoryId);

        $payload = json_encode($prestaions);

        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}