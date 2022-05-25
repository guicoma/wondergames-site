<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Wondergames\Site\Controller\UserSessionController;
use Wondergames\Site\Controller\SignUpController;
use Wondergames\Site\Controller\EventsController;
use Wondergames\Site\Controller\CommunityController;
use Wondergames\Site\Repository\MySQLUserRepository;
use Wondergames\Site\Repository\PDOConnectionBuilder;

use Slim\Views\Twig;

use GuzzleHttp\Client;

function addDependencies(ContainerInterface $container): void
{
    $container->set(
        'view',
        function () {
            $twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);
            $environment = $twig->getEnvironment();
            $environment->addGlobal('session', $_SESSION);
            return $twig;
        }
    );

    $container->set('db', function () {
        $connectionBuilder = new PDOConnectionBuilder();
        return $connectionBuilder->build(
            $_ENV['MYSQL_ROOT_USER'],
            $_ENV['MYSQL_ROOT_PASSWORD'],
            $_ENV['MYSQL_HOST'],
            $_ENV['MYSQL_PORT'],
            $_ENV['MYSQL_DATABASE']
        );
    });

    $container->set('user_repository', function (ContainerInterface $container) {
        return new MySQLUserRepository($container->get('db'));
    });

    $container->set(
        UserSessionController::class,
        function (ContainerInterface $c) {
            return new UserSessionController($c->get('view'), $c->get('user_repository'));
        }
    );

    $container->set(
        SignUpController::class,
        function (ContainerInterface $c) {
            return new SignUpController($c->get('view'), $c->get('user_repository'));
        }
    );

    $container->set(
        EventsController::class,
        function (ContainerInterface $c) {
            $http = new GuzzleHttp\Client;
            return new EventsController($c->get('view'), $c->get('user_repository'), $http);
        }
    );

    $container->set(
        CommunityController::class,
        function (ContainerInterface $c) {
            $http = new GuzzleHttp\Client;
            return new CommunityController($c->get('view'), $c->get('user_repository'), $http);
        }
    );
}
