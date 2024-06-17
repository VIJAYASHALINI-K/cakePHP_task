<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::defaultRouteClass(DashedRoute::class);
Router::scope('/api', function (RouteBuilder $routes) {
    $routes->connect('/api/users', ['controller' => 'Users', 'action' => 'add']);
    $routes->connect('/api/users', ['controller' => 'Users', 'action' => 'update']);
    $routes->connect('/api/users', ['controller' => 'Users', 'action' => 'delete']);
    $routes->connect('/api/users', ['controller' => 'Users', 'action' => 'display']);
    $routes->setExtensions(['json', 'xml']);
    $routes->fallbacks(DashedRoute::class);
});