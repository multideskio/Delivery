<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


//Rotas bot
$routes->group('api/bot', static function ($routes){

    $routes->get('menu/text', 'Api\V1\MenuController::text');
    
    $routes->post('clientes', 'Api\V1\ClientesController::cadCliente');
    $routes->post('clientes/busca', 'Api\V1\ClientesController::getCliente');

    $routes->post('pedido', 'Api\V1\PedidosController::create');
    $routes->post('pedido/status', 'Api\V1\PedidosController::status');
    

});


//Rotas do sistema
$routes->group('api/v1', static function ($routes){

    $routes->resource('menu', ['controller' => 'Api\V1\MenuController']);
    $routes->resource('clientes', ['controller' => 'Api\V1\ClientesController']);
});
