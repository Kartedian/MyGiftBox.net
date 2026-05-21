<?php

namespace Dwm\MyGiftBox\webui\actions;

use Dwm\MyGiftBox\application_core\application\usecases\CatalogueServiceInterface;
use Dwm\MyGiftBox\application_core\domain\exceptions\CatalogueException;
use Dwm\MyGiftBox\application_core\domain\exceptions\EntityNotFoundException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

class PrestationDetailAction
{
    public function __construct(private readonly CatalogueServiceInterface $catalogue) {}

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];

        try {
            $prestation = $this->catalogue->getPrestationById($id);
        } catch (EntityNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        } catch (CatalogueException $e) {
            throw new HttpInternalServerErrorException($request, $e->getMessage());
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'PrestationDetailView.html', $prestation);
    }
}
