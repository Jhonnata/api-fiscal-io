<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->addRedirect('/', 'doc');
$routes->get('doc', 'ApiController::index');
