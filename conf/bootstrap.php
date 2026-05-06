<?php
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as DB;

$config = parse_ini_file(__DIR__ . '/confdb.ini');
if ($config !== false) {
    $db = new DB();
    $db->addConnection($config);
    $db->setAsGlobal();
    $db->bootEloquent();
}

$config = parse_ini_file(__DIR__ . '/config.ini');

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->setBasePath($config['BasePath']);
$app->addErrorMiddleware(true, true, true);


$routes = require_once __DIR__ . '/Routes.php';
$app = $routes($app);

return $app;