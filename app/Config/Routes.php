<?php

use App\Controllers\InventarioController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
// Inventory Routes
$routes->get('/inventario', [InventarioController::class,'index'], ['filter' => 'auth']); 
$routes->get('/inventario/create', 'InventarioController::createInventario', ['filter' => 'auth']); 
$routes->post('/inventario/insert', 'InventarioController::insertInventario', ['filter' => 'auth']); 
$routes->get('/inventario/edit/(:num)', 'InventarioController::editInventario/$1', ['filter' => 'auth']); 
$routes->post('/inventario/update/(:num)', 'InventarioController::updateInventario/$1', ['filter' => 'auth']); 
$routes->get('/inventario/delete/(:num)', 'InventarioController::deleteInventario/$1', ['filter' => 'auth']); 

$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::createUser');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::authenticate');
$routes->get('/logout', 'AuthController::logout', ['filter' => 'auth']);
