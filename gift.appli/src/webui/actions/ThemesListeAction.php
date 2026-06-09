<?php

namespace Dwm\MyGiftBox\webui\actions;

use Dwm\MyGiftBox\application_core\application\usecases\CatalogueServiceInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Views\Twig;

class ThemesListeAction
{
    public function __construct(private readonly CatalogueServiceInterface $catalogue){}

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try{
            $themes = $this->catalogue->getThemes();
        } catch (CatalogueException $e) {
            throw new HttpInternalServerErrorException($request, $e->getMessage());
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'ThemeListeView.html', [
            'theme_liste' => $themes,
        ]);
    }
}