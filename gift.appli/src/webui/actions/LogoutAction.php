<?php

namespace Dwm\MyGiftBox\webui\actions;


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Dwm\MyGiftBox\webui\provider\AuthnProvider;

class LogoutAction
{
    public function __invoke(Request $request, Response $response, array $args)
    {
        AuthnProvider::logout(); // Appelle la méthode de déconnexion pour supprimer la session
        return $response
            ->withHeader('Location', '/')
            ->withStatus(302); // Redirige vers la page d'accueil après la déconnexion
    }
}