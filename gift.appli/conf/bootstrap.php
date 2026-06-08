<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

use Dwm\MyGiftBox\application_core\application\usecases\CatalogueService;
use Dwm\MyGiftBox\application_core\application\usecases\CatalogueServiceInterface;
use Dwm\MyGiftBox\application_core\application\usecases\BoxService;
use Dwm\MyGiftBox\application_core\application\usecases\BoxServiceInterface;
use Dwm\MyGiftBox\webui\AppContainer;
use Illuminate\Database\Capsule\Manager as DB;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Dwm\MyGiftBox\webui\provider\AuthnProvider;

// --- Base de données ----------------------------------------------------------
$config = parse_ini_file(__DIR__ . '/confdb.ini');
if ($config !== false) {
    $db = new DB();
    $db->addConnection($config);
    $db->setAsGlobal();
    $db->bootEloquent();
}

// --- Conteneur de dépendances (Illuminate Container = PSR-11) ----------------
$container = new AppContainer();
$container->bind(CatalogueServiceInterface::class, CatalogueService::class);
$container->bind(BoxServiceInterface::class,       BoxService::class);

AppFactory::setContainer($container);
$app = AppFactory::create();

// --- Vues Twig ----------------------------------------------------------------
$twig = Twig::create(__DIR__ . '/../src/webui/views', ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));

// Ajout d'une variable globale pour vérifier l'authentification dans les templates Twig
$twig->getEnvironment()->addGlobal('isAuthenticated', AuthnProvider::isAuthenticated());

// --- Middlewares --------------------------------------------------------------
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

// --- Routes -------------------------------------------------------------------
$routes = require_once __DIR__ . '/Routes.php';
$app    = $routes($app);

return $app;