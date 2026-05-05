<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as DB;

$config = parse_ini_file(__DIR__ . '/conf/confdb.ini');
if ($config !== false) {
    $db = new DB();
    $db->addConnection($config);
    $db->setAsGlobal();
    $db->bootEloquent();
}

$config = parse_ini_file(__DIR__ . '/conf/config.ini');

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->setBasePath($config['BasePath']);
$app->addErrorMiddleware(true, true, true);


$routes = require_once __DIR__ . '/conf/Routes.php';
$app = $routes($app);

$app->run();