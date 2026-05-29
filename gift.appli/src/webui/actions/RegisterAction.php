<?php

namespace Dwm\MyGiftBox\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Dwm\MyGiftBox\webui\provider\AuthnProvider;
use Slim\Views\Twig;

class RegisterAction
{
    public function __invoke(Request $request, Response $response, array $args)
    {
        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $email = $data['email'] ?? null;
            $password = $data['password'] ?? null;

            if ($email && $password) {
                try {
                    if (AuthnProvider::register($email, $password)) {
                        return $response
                            ->withHeader('Location', '/login')
                            ->withStatus(302);
                    } else {
                        $view = Twig::fromRequest($request);
                        return $view->render($response, 'Register.html', ['error' => 'L\'inscription a échoué']);
                    }
                } catch (\Exception $e) {
                    $view = Twig::fromRequest($request);
                    return $view->render($response, 'Register.html', ['error' => 'Une erreur est survenue lors de l\'inscription : ' . $e->getMessage()]);
                }
            } else {
                $view = Twig::fromRequest($request);
                return $view->render($response, 'Register.html', ['error' => 'Veuillez remplir tous les champs']);
            }
        }
        $view = Twig::fromRequest($request);
        return $view->render($response, 'Register.html');
    }
}