<?php

namespace Dwm\MyGiftBox\api;

use Dwm\MyGiftBox\application_core\application\usecases\CatalogueServiceInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class GetCategoriesApi
{
    public function __construct(private readonly CatalogueServiceInterface $catalogue) {}

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $categories = $this->catalogue->getCategories();

        $payload = json_encode($categories);

        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}