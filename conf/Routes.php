<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function ( \slim\App $app ) : \Slim\App {
    $app->get(pattern: '/categories[/]', 
    function (Request $rq, Response $rs, array $args) : Response {
        $html = <<<HTML
        <html>
            <head>
                <title>Categories</title>
            </head>
            <body>
                <h1>Categories</h1>
                <ul>
                    <li><a href="/categories/1">restauration</a></li>
                    <li><a href="/categories/2">hébergement</a></li>
                    <li><a href="/categories/3">attention</a></li>
                    <li><a href="/categories/4">activité</a></li>
                    <li><a href="/categories/5">petit trucs</a></li>
                </ul>
            </body>
        </html>
        HTML;

        $rs->getBody()->write($html);
        return $rs;


    } );
    
};

$app->get(pattern:'/categories/{id:\d+}[/]', function ( Request $rq, Response $rs, array $args) : Response {
    $html = <<<HTML