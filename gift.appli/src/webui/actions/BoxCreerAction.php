<?php

namespace Dwm\MyGiftBox\webui\actions;
use Dwm\MyGiftBox\application_core\application\usecases\BoxServiceInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class BoxCreerAction
{
    public function __invoke(Request $request, Response $response, array $args){
        $view = Twig::fromRequest($request);
        return $view->render($response, 'BoxCreateView.html', []);
    }
}