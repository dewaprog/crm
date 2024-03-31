<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'home::index');
$routes->get('/wa', 'Wa::index');
$routes->get('/newWA', 'Wa::newWA');
$routes->get('/message/(:any)', 'Wa::getMessage/$1');

$routes->get('/user', 'User::index');

$routes->get('/company', 'master::company');
$routes->post('/company/save', 'master::company_save');
$routes->post('/company/save/(:num)', 'master::company_save/$1');
$routes->delete('/company', 'master::company_delete');

$routes->post('/project/save', 'master::project_save');
