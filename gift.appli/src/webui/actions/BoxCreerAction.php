<?php

namespace Dwm\MyGiftBox\webui\actions;
use Dwm\MyGiftBox\application_core\application\usecases\BoxService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class BoxCreerAction
{
    public function __invoke(Request $request, Response $response, array $args){
        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            if(empty($data['libelle'])) {
                $response->getBody()->write('Données manquantes');
                error_log("Données de création de box manquantes : " . json_encode($data));
                return $response->withStatus(400);
            }

            $libelle = $data['libelle'];
            $description = $data['description'] ?? null;
            $kdo = $data['kdo'] ?? false;
            $message_kdo = $data['message_kdo'] ?? null;

            try {
                $boxService = new BoxService();
                $box = $boxService->createBox($libelle, $description, $kdo, $message_kdo, null);
                error_log("Box créée avec succès : " . json_encode($box));
            } catch (\Exception $e) {
                $response->getBody()->write('Erreur lors de la création de la box : ' . $e->getMessage());
                error_log("Erreur lors de la création de la box : " . $e->getMessage());
                return $response->withStatus(500);
            }


            return $response->withHeader('Location', '/boxes')->withStatus(302);
        }
        
        $view = Twig::fromRequest($request);
        return $view->render($response, 'BoxCreateView.html', []);
    }
}