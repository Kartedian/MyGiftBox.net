<?php

namespace Dwm\MyGiftBox\webui\actions;

use Dwm\MyGiftBox\application_core\application\usecases\CatalogueServiceInterface;
use Dwm\MyGiftBox\application_core\domain\exceptions\CatalogueException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Views\Twig;

class Coffret_typeListeAction
{
    public function __construct(private readonly CatalogueServiceInterface $catalogue) {}

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $coffretTypes = $this->catalogue->getThemesCoffrets();
        } catch (CatalogueException $e) {
            throw new HttpInternalServerErrorException($request, $e->getMessage());
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'Coffret_typeListeView.html', [
            'coffret_type_liste' => $coffretTypes,
        ]);
    }
}
