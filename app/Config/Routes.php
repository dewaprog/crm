<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/wa', 'Wa::index');
$routes->get('/newWA', 'Wa::newWA');
$routes->get('/message/(:any)', 'Wa::getMessage/$1');

$routes->get('/user', 'User::index');
