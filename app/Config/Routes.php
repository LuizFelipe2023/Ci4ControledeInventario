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

$routes->get('/inventario', [InventarioController::class, 'index'], ['filter' => ['auth', 'checkUser']]);
$routes->get('/inventario/create', [InventarioController::class, 'createInventario'], ['filter' => ['auth', 'checkUser']]);
$routes->post('/inventario/insert', [InventarioController::class, 'insertInventario'], ['filter' => ['auth', 'checkUser']]);
$routes->get('/inventario/show/(:num)', [InventarioController::class, 'show'], ['filter' => ['auth', 'checkUser']]);
$routes->get('/inventario/edit/(:num)', [InventarioController::class, 'editInventario'], ['filter' => ['auth', 'checkUser']]);
$routes->post('/inventario/update/(:num)', [InventarioController::class, 'updateInventario'], ['filter' => ['auth', 'checkUser']]);
$routes->get('/inventario/delete/(:num)', [InventarioController::class, 'deleteInventario'], ['filter' => ['auth', 'checkUser']]);

$routes->get('/clientes', [ClienteController::class, 'home'], ['filter' => ['auth', 'checkUser']]);
$routes->get('/clientes/create', [ClienteController::class, 'createCliente'], ['filter' => ['auth', 'checkUser']]);
$routes->post('/clientes/insert', [ClienteController::class, 'insertCliente'], ['filter' => ['auth', 'checkUser']]);
$routes->get('/clientes/show/(:num)', [ClienteController::class, 'showCliente'], ['filter' => ['auth', 'checkUser']]);
$routes->get('/clientes/edit/(:num)', [ClienteController::class, 'editCliente'], ['filter' => ['auth', 'checkUser']]);
$routes->post('/clientes/update/(:num)', [ClienteController::class, 'updateCliente'], ['filter' => ['auth', 'checkUser']]);
$routes->get('/clientes/delete/(:num)', [ClienteController::class, 'deleteCliente'], ['filter' => ['auth', 'checkUser']]);

$routes->get('/vendas', [VendaController::class, 'dashboardVendas'], ['filter' => ['auth', 'checkUser']]);
$routes->get('/vendas/create', [VendaController::class, 'createVendas'], ['filter' => ['auth', 'checkUser']]); 
$routes->post('/vendas/store', [VendaController::class, 'storeVendas'], ['filter' => ['auth', 'checkUser']]);
$routes->get('/vendas/edit/(:num)', [VendaController::class, 'edit'], ['filter' => ['auth', 'checkUser']]);
$routes->post('/vendas/update/(:num)', [VendaController::class, 'update'], ['filter' => ['auth', 'checkUser']]);
$routes->get('/vendas/show/(:num)', [VendaController::class, 'show'], ['filter' => ['auth', 'checkUser']]);
$routes->get('/vendas/delete/(:num)', [VendaController::class, 'delete'], ['filter' => ['auth', 'checkUser']]);

$routes->get('/verify-email', [AuthController::class, 'verifyEmail']); 
$routes->post('/send-verification-email', [AuthController::class, 'sendVerificationEmail']); 
$routes->get('/verify-token', [AuthController::class, 'verifyToken']);
$routes->post('/validate-token', [AuthController::class, 'validateToken']); 

$routes->get('/request-reset-password', [AuthController::class, 'requestResetPassword']);
$routes->post('/send-reset-token', [AuthController::class, 'sendResetToken']);
$routes->get('/reset-password', [AuthController::class, 'resetPassword']);
$routes->post('/update-password', [AuthController::class, 'updatePassword']);


