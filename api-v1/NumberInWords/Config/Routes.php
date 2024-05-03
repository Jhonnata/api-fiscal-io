<?php
namespace API\Example\Config;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('number-in-words', ['namespace' => 'API\NumberInWords\Controllers'], function ($routes) {
//    $routes->get('/heartbeat', 'Example::heartbeat',['filter' => 'authorization:dev.*,admin.*,example.*']);
//    $routes->resources();
    $routes->get('(:num)', 'NumberInWords::index/$1');
    $routes->get('/', 'NumberInWords::index');
});
