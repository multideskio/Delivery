<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->group('api/v1', static function ($routes){

    $routes->get('menu/text', 'Api\V1\MenuController::text');
    $routes->resource('menu', ['controller' => 'Api\V1\MenuController']);
});
