<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Cliente;
use App\Models\Inventario;
use App\Models\Venda;
use CodeIgniter\HTTP\ResponseInterface;


class VendaController extends BaseController
{
    public function dashboardVendas()
    {
           $vendaModel = new Venda();
           $vendas = $vendaModel->orderBy('id','ASC')->findAll();

           return view('vendas/dashboard',['vendas' => $vendas]);
    }

    public function create()
    {
        $inventarioModel = new Inventario();
        $clienteModel = new Cliente();

        $itensInventario = $inventarioModel->findAll();
        $clientes = $clienteModel->findAll();

        return view('vendas/create', ['itensInventario' => $itensInventario, 'clientes' => $clientes]);
    }
}
