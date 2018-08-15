<?php

use Refactor\Application\Controller\MiscController;
use Refactor\Application\Controller\UsersController;
use Refactor\Common\Request\Request;

return [
     'users' => [
        'regexp' => '~^(?P<uri>/users/?)$~',
        'method' => Request::METHOD_GET,
        'controller' => UsersController::class,
        'action' => 'getList',
    ],

    'users/:id' => [
        'regexp' => '~^(?P<uri>/users/(?P<id>\w+)/?)$~',
        'method' => Request::METHOD_GET,
        'controller' => UsersController::class,
        'action' => 'getOne',
    ],

    'OPTIONS' => [
        'regexp' => '/.*/',
        'method' => Request::METHOD_OPTIONS,
        'controller' => MiscController::class,
        'action' => 'methodOptions',
    ],
];
