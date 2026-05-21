<?php

namespace Dwm\MyGiftBox\webui\actions;

use Dwm\MyGiftBox\application_core\application\usecases\BoxServiceInterface;
use Dwm\MyGiftBox\application_core\domain\exceptions\BoxException;
use Dwm\MyGiftBox\application_core\domain\exceptions\EntityNotFoundException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

/**
 * Génère ou retourne le token d'accès d'une box, puis affiche la page de partage.
 * URL : GET /box/{id}/token
 *
 * Règles de gestion :
 *  - La box doit exister (sinon 404).
 *  - La box doit être dans l'état ACTIF (statut 5) pour qu'un token puisse être
 *    généré ou retourné (sinon 403).
 *  - Si la box possède déjà un token, il est retourné tel quel (idempotent).
 *  - Un nouveau token sécurisé (64 hex chars = 32 bytes) est créé et persisté
 *    uniquement si le champ token est vide.
 */
class BoxTokenAction
{
    public function __construct(private readonly BoxServiceInterface $boxService) {}

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $boxId = $args['id'];

        try {
            $token = $this->boxService->genererToken($boxId);
            $box   = $this->boxService->getBoxById($boxId);
        } catch (EntityNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        } catch (BoxException $e) {
            throw new HttpForbiddenException($request, $e->getMessage());
        } catch (\RuntimeException $e) {
            throw new HttpInternalServerErrorException($request, $e->getMessage());
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'BoxTokenView.html.twig', [
            'box'   => $box,
            'token' => $token,
        ]);
    }
}
