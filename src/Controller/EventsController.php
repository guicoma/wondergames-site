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

final class EventsController
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
    public function showEventsPage(Request $request, Response $response): Response
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        // Here we define our query as a multi-line string
        $query = '
            query ($username: String) { # Define which variables will be used in the query (id)
                MediaListCollection(userName: $username, type: ANIME) {
                    lists {
                        name
                        status
                        entries {
                            id
                            status
                            progress
                            media {
                                coverImage {
                                    color
                                    large
                                }
                                title {
                                    romaji
                                    english
                                }
                                description
                                episodes
                                averageScore
                            }
                        }
                    }
                }
            }
        ';

        // Define our query variables and values that will be used in the query request
        $variables = [
            "username" => "Wondergames"
        ];

        try {
            $aniData = @file_get_contents('https://graphql.anilist.co', false, stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header' => ['Content-Type: application/json'],
                    'content' => json_encode(['query' => $query, 'variables' => $variables]),
                ]
            ]));
            $aniData = json_decode($aniData, true);
        } catch (\Throwable $th) {
            echo "Error API anilist request";
            $aniData = [];
        }

        try {
            $apiChallonge = 'https://api.challonge.com/v1/tournaments.json';
            $params = [
                'header' => ['Content-Type: application/json'],
                'query' => [
                    'api_key' => $_ENV['APIKEY_CHALLONGE'],
                    'state' => 'all',
                    'subdomain' => 'wondergames'
                ]
            ];
            $challongeData = $this->http->get($apiChallonge, $params);
        } catch (\Throwable $th) {
            echo "Error API challonge request";
            $challongeData = [];
        }

        $challongeData = json_decode($challongeData->getBody()->getContents(), true);


        //echo json_decode($data, true);

        return $this->twig->render(
            $response,
            'events.twig',
            [
                'formAction'    => $routeParser->urlFor('signUp'),
                'aniData'       => $aniData,
                'challongeData' => $challongeData
            ]
        );
    }

}
