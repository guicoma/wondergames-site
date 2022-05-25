<?php

declare(strict_types=1);

namespace Wondergames\Site\Controller;

use Wondergames\Site\Service\ValidatorService;
use Wondergames\Site\Repository\UserRepository;
use Wondergames\Site\Model\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Routing\RouteContext;
use Slim\Views\Twig;

use GuzzleHttp\Client;

use DateTime;

final class CommunityController
{
    private Twig $twig;
    private ValidatorService $validator;
    private UserRepository $userRepository;
    private $http;

    public function __construct(
        Twig $twig,
        UserRepository $userRepository,
        Client $http
    ) {
        $this->twig = $twig;
        $this->userRepository = $userRepository;
        $this->validator = new ValidatorService();
        $this->http = $http;
    }

    /**
     * Renders the form
     */
    public function showCommunityPage(Request $request, Response $response): Response
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();


        return $this->twig->render(
            $response,
            'community.twig',
            [
                'formAction'    => $routeParser->urlFor('signUp')
            ]
        );
    }

}
