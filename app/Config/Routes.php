<?php

use App\Controllers\AuthController;
use App\Controllers\InventarioController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

$routes->get('/', [AuthController::class, 'login']);
$routes->post('/login', [AuthController::class, 'authenticate']);
$routes->get('/logout', [AuthController::class, 'logout'], ['filter' => 'auth']); 
$routes->get('/register', [AuthController::class, 'register']);
$routes->post('/register', [AuthController::class, 'createUser']);


$routes->get('/inventario', [InventarioController::class, 'index'], ['filter' => 'auth']); 
$routes->get('/inventario/create', [InventarioController::class, 'createInventario'], ['filter' => 'auth']); 
$routes->post('/inventario/insert', [InventarioController::class, 'insertInventario'], ['filter' => 'auth']); 
$routes->get('/inventario/show/(:num)', [InventarioController::class, 'show'], ['filter' => 'auth']);
$routes->get('/inventario/edit/(:num)', [InventarioController::class, 'editInventario'], ['filter' => 'auth']); 
$routes->post('/inventario/update/(:num)', [InventarioController::class, 'updateInventario'], ['filter' => 'auth']); 
$routes->get('/inventario/delete/(:num)', [InventarioController::class, 'deleteInventario'], ['filter' => 'auth']); 