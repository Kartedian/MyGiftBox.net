<?php

namespace Dwm\MyGiftBox\webui\actions;

use Dwm\MyGiftBox\application_core\application\usecases\CatalogueServiceInterface;
use Dwm\MyGiftBox\application_core\domain\exceptions\CatalogueException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Views\Twig;

class PrestationListeAction
{
    public function __construct(private readonly CatalogueServiceInterface $catalogue) {}

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            // Récupère toutes les prestations via toutes les catégories
            $categories = $this->catalogue->getCategories();
            $prestations = [];
            foreach ($categories as $cat) {
                foreach ($this->catalogue->getPrestationsByCategorie($cat->id) as $p) {
                    $prestations[] = $p;
                }
            }
        } catch (CatalogueException $e) {
            throw new HttpInternalServerErrorException($request, $e->getMessage());
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'PrestationListeView.html', [
            'prestation_liste' => $prestations,
        ]);
    }
}
