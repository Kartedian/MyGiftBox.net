<?php
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as DB;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$config = parse_ini_file(__DIR__ . '/confdb.ini');
if ($config !== false) {
    $db = new DB();
    $db->addConnection($config);
    $db->setAsGlobal();
    $db->bootEloquent();
}

$app = AppFactory::create();

$twig = Twig::create(__DIR__ . '/../src/views', ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);


$routes = require_once __DIR__ . '/Routes.php';
$app = $routes($app);

return $app;