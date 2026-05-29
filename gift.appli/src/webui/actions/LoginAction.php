<?php

namespace Dwm\MyGiftBox\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Dwm\MyGiftBox\webui\provider\AuthnProvider;
use Slim\Views\Twig;

class LoginAction
{
    public function __invoke(Request $request, Response $response, array $args)
    {
        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $email = $data['email'] ?? null;
            $password = $data['password'] ?? null;

            if ($email && $password) {
                try {
                    if (AuthnProvider::authenticate($email, $password)) {
                        return $response
                            ->withHeader('Location', '/')
                            ->withStatus(302);
                    } else {
                        $view = Twig::fromRequest($request);
                        return $view->render($response, 'Login.html', ['error' => 'Email ou mot de passe incorrect']);
                    }
                } catch (\Exception $e) {
                    $view = Twig::fromRequest($request);
                    return $view->render($response, 'Login.html', ['error' => 'Une erreur est survenue lors de l\'authentification : ' . $e->getMessage()]);
                }
            } else {
                $view = Twig::fromRequest($request);
                return $view->render($response, 'Login.html', ['error' => 'Veuillez remplir tous les champs']);
            }
        }
        $view = Twig::fromRequest($request);
        return $view->render($response, 'Login.html');
    }
}