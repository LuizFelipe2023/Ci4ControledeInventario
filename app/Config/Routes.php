<?php

use App\Controllers\AuthController;
use App\Controllers\ClienteController;
use App\Controllers\InventarioController;
use App\Controllers\VendaController;
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


$routes->get('/clientes', [ClienteController::class, 'home'], ['filter' => 'auth']);
$routes->get('/clientes/create', [ClienteController::class, 'createCliente'], ['filter' => 'auth']);
$routes->post('/clientes/insert', [ClienteController::class, 'insertCliente'], ['filter' => 'auth']);
$routes->get('/clientes/show/(:num)', [ClienteController::class, 'showCliente'], ['filter' => 'auth']);
$routes->get('/clientes/edit/(:num)', [ClienteController::class, 'editCliente'], ['filter' => 'auth']);
$routes->post('/clientes/update/(:num)', [ClienteController::class, 'updateCliente'], ['filter' => 'auth']);
$routes->get('/clientes/delete/(:num)', [ClienteController::class, 'deleteCliente'], ['filter' => 'auth']);



$routes->get('/vendas', [VendaController::class, 'dashboardVendas'], ['filter' => 'auth']);
$routes->get('/vendas/create', [VendaController::class, 'createVendas'], ['filter' => 'auth']); // Corrected the method name to createVendas
$routes->post('/vendas/store', [VendaController::class, 'storeVendas'], ['filter' => 'auth']);
$routes->get('/vendas/edit/(:num)', [VendaController::class, 'edit'], ['filter' => 'auth']);
$routes->post('/vendas/update/(:num)', [VendaController::class, 'update'], ['filter' => 'auth']);
$routes->get('/vendas/show/(:num)', [VendaController::class, 'show'], ['filter' => 'auth']);
$routes->get('/vendas/delete/(:num)', [VendaController::class, 'delete'], ['filter' => 'auth']);
