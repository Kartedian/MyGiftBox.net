<?php

namespace Dwm\MyGiftBox\webui\actions;

use Dwm\MyGiftBox\application_core\application\usecases\CatalogueServiceInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

class Theme2CoffretsTypeAction
{
    public function __construct(private readonly CatalogueServiceInterface $catalogue){}

    public function __invoke(Request $request, Response $response, array $args)
    {
        $id = (int) $args['id'];

        try{
            $theme = $this->catalogue->getThemeById($id);
            $listeCoffretType = $this->catalogue->getCoffretByThemeId($id);
        } catch (EntityNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        } catch (CatalogueException $e) {
            throw new HttpInternalServerErrorException($request, $e->getMessage());
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'Theme2CoffretsTypesView.html', [
            'id'                => $theme['id'],
            'libelle'           => $theme['libelle'],
            'listeCoffretType'  => $listeCoffretType,
        ]);
    }
}