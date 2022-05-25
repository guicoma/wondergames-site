<?php

declare(strict_types=1);

use Wondergames\Site\Controller\API\BlogAPIController;
use Wondergames\Site\Controller\UserSessionController;
use Wondergames\Site\Controller\SignUpController;
use Wondergames\Site\Controller\EventsController;
use Wondergames\Site\Controller\CommunityController;
use Slim\App;

function addRoutes(App $app): void
{
    $app->get('/', UserSessionController::class . ':showLandingPage');

    $app->post('/logout', UserSessionController::class . ':logout')->setName('logoutAction');
    
    $app->get('/sign-in', UserSessionController::class . ':showSignInForm')->setName('signIn');
    $app->post('/sign-in', UserSessionController::class . ':signIn')->setName('signInAction');

    $app->get('/sign-up', SignUpController::class . ':showSignUpForm')->setName('signUp');
    $app->post('/sign-up', SignUpController::class . ':signUp')->setName('signUpAction');

    $app->get('/events', EventsController::class . ':showEventsPage');

    $app->get('/community', CommunityController::class . ':showCommunityPage');
}
