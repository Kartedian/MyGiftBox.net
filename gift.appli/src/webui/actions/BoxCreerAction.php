<?php

namespace Dwm\MyGiftBox\webui\actions;
use Dwm\MyGiftBox\application_core\application\usecases\BoxService;
use Dwm\MyGiftBox\webui\provider\CsrfTokenProvider;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Dwm\MyGiftBox\application_core\application\usecases\CatalogueService;

class BoxCreerAction
{
    private $catalogue;

    public function __construct(CatalogueService $catalogue)
    {
        $this->catalogue = $catalogue;
    }

    public function __invoke(Request $request, Response $response, array $args){
        $coffretId = $request->getQueryParams()['coffret'] ?? null;
        if ($coffretId !== null)
            $coffret = $this->catalogue->getCoffretById($coffretId);

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $csrfToken = $data['csrf_token'] ?? null;
            if (!CsrfTokenProvider::validateToken($csrfToken) || empty($data['libelle'])) {
                throw new HttpBadRequestException($request, 'Données de création de box invalides');
            }

            $libelle = $data['libelle'];
            $description = $data['description'] ?? null;
            $kdo = $data['kdo'] ?? false;
            $message_kdo = $data['message_kdo'] ?? null;
            $coffretType = $data['coffretType'] ?? null;

            try {
                $boxService = new BoxService();
                $box = $boxService->createBox($libelle, $description, $kdo, $message_kdo, $coffretType);
                error_log("Box créée avec succès : " . json_encode($box));
            } catch (\Exception $e) {
                error_log("Erreur lors de la création de la box : " . $e->getMessage());
                throw new HttpInternalServerErrorException($request, 'Erreur lors de la création de la box');
            }


            return $response->withHeader('Location', '/boxes')->withStatus(302);
        }
        
        $view = Twig::fromRequest($request);
        return $view->render($response, 'BoxCreateView.html', [
            'csrf_token' => CsrfTokenProvider::generateToken(),
            'coffret_type_liste' =>$this->catalogue->getThemesCoffrets(),
        ]);
    }
}