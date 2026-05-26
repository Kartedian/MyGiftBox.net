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
 * Affiche le détail d'une box à partir de son token public.
 * URL : GET /box/{token}
 */
class BoxDetailAction
{
    public function __construct(private readonly BoxServiceInterface $boxService) {}

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $token = $request->getQueryParams()['token'] ?? null;
        if ($token === null) {
            throw new HttpNotFoundException($request, "Token de box manquant");
        }

        try {
            $box = $this->boxService->getBoxByToken($token);
        } catch (BoxException $e) {
            // Token invalide → 404, box non utilisable → 403
            if (str_contains($e->getMessage(), 'invalide')) {
                throw new HttpNotFoundException($request, $e->getMessage());
            }
            throw new HttpForbiddenException($request, $e->getMessage());
        } catch (\RuntimeException $e) {
            throw new HttpInternalServerErrorException($request, $e->getMessage());
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'BoxDetailView.html.twig', [
            'box' => $box,
        ]);
    }
}
