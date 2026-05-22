<?php

namespace Dwm\MyGiftBox\webui\actions;

use Dwm\MyGiftBox\application_core\application\usecases\BoxServiceInterface;
use Dwm\MyGiftBox\application_core\domain\exceptions\BoxException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Views\Twig;

class BoxListeAction
{
    public function __construct(private readonly BoxServiceInterface $box){}

    public function __invoke(Request $request, Response $response, array $args)
    {
        try{
            $boxes = $this->box->getBoxes();
        }catch (BoxException $e){
            throw new HttpInternalServerErrorException($request, $e->getMessage());
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'BoxListeView.html', [
            'box_liste' => $boxes,
        ]);
    }
}