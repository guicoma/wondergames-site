<?php
declare(strict_types=1);

use DI\Container;
use Wondergames\Site\ErrorHandler\HttpErrorHandler;
use Wondergames\Site\Middleware\StartSessionMiddleware;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

session_start(); //$_SESSION

$dotenv = new Dotenv();

$dotenv->load(__DIR__ . '/../.env');

$container = new Container();

require_once __DIR__ . '/../config/dependencies.php';

addDependencies($container);

AppFactory::setContainer($container);

$app = AppFactory::create();

$callableResolver = $app->getCallableResolver();
$responseFactory = $app->getResponseFactory();

$app->add(StartSessionMiddleware::class);

$app->addBodyParsingMiddleware();

$app->add(TwigMiddleware::createFromContainer($app));

$app->addRoutingMiddleware();

$app->addErrorMiddleware(true, false, false);

require_once __DIR__ . '/../config/routing.php';

addRoutes($app);

$app->run();