<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Cliente;
use App\Models\Inventario;
use App\Models\Venda;

class VendaController extends BaseController
{
    public function dashboardVendas()
    {
        $vendaModel = new Venda();
        $vendas = $vendaModel->orderBy('id', 'ASC')->findAll();

        if (empty($vendas)) {
            return view('vendas/dashboardVenda', ['vendas' => []]);
        }

        $clienteIds = array_column($vendas, 'cliente_id');

        if (empty($clienteIds)) {
            throw new \Exception('No client IDs found in vendas');
        }

        $clienteModel = new Cliente();
        $clientes = $clienteModel->whereIn('id', $clienteIds)->findAll();

        foreach ($vendas as &$venda) {
            foreach ($clientes as $cliente) {
                if ($cliente['id'] == $venda['cliente_id']) {
                    $venda['cliente_nome'] = $cliente['nome'];
                    break;
                }
            }
        }

        return view('vendas/dashboardVenda', ['vendas' => $vendas]);
    }

    public function createVendas()
    {
        $inventarioModel = new Inventario();
        $clienteModel = new Cliente();

        $clientes = $clienteModel->findAll();
        $itensInventario = $inventarioModel->findAll();

        return view('vendas/createVenda', [
            'clientes' => $clientes,
            'itensInventario' => $itensInventario
        ]);
    }

    public function storeVendas()
    {
        $vendasData = $this->request->getPost();
        $vendaModel = new Venda();
        $inventarioModel = new Inventario();
        $clienteModel = new Cliente();

        // Log incoming data
        log_message('info', 'Incoming Venda data: ' . json_encode($vendasData));

        $clienteId = $vendasData['cliente_id'];
        $itens = $vendasData['inventarios'];
        $valorTotal = 0;

        if (!$clienteModel->find($clienteId)) {
            log_message('error', 'Cliente não encontrado: ' . $clienteId);
            return redirect()->back()->with('errors', ['Cliente não encontrado.']);
        }

        $itensVendidos = [];

        foreach ($itens as $item) {
            $itemData = $inventarioModel->find($item['id']);

            if ($itemData) {
                if ($itemData['quantity'] >= $item['quantity']) {
                    $valorItem = $itemData['price'];
                    $quantidade = $item['quantity'];
                    $valorTotal += $valorItem * $quantidade;

                    // Log inventory update
                    log_message('info', 'Updating inventory for item: ' . $item['id'] . ', quantity: ' . $quantidade);
                    $inventarioModel->update($item['id'], [
                        'quantity' => $itemData['quantity'] - $quantidade
                    ]);

                    $itensVendidos[] = [
                        'id' => $item['id'],
                        'name' => $itemData['name'],
                        'quantity' => $quantidade,
                        'price' => $valorItem
                    ];
                } else {
                    log_message('error', 'Quantidade insuficiente para o item: ' . $itemData['name']);
                    return redirect()->back()->with('errors', ['Quantidade insuficiente para o item: ' . $itemData['name']]);
                }
            } else {
                log_message('error', 'Item não encontrado: ' . $item['id']);
            }
        }

        $data = [
            'cliente_id' => $clienteId,
            'valor_total' => $valorTotal,
            'data_venda' => date('Y-m-d H:i:s'),
            'itens_vendidos' => json_encode($itensVendidos),
            'forma_de_pagamento' => $this->request->getPost('forma_de_pagamento')
        ];

        if (!$vendaModel->save($data)) {
            log_message('error', 'Erro ao registrar a venda: ' . json_encode($vendaModel->errors()));
            return redirect()->back()->with('errors', ['Erro ao registrar a venda.']);
        }

        log_message('info', 'Venda registrada com sucesso: ' . json_encode($data));
        return redirect()->to('/vendas')->with('success', 'Vendas registradas com sucesso!');
    }

    public function edit($id)
    {
        $vendaModel = new Venda();
        $inventarioModel = new Inventario();
        $clienteModel = new Cliente();

        $venda = $vendaModel->find($id);
        $inventarios = $inventarioModel->findAll();
        $clientes = $clienteModel->findAll();

        if (!$venda) {
            return redirect()->to('/vendas')->with('error', 'Venda não encontrada.');
        }

        return view('vendas/editVenda', [
            'venda' => $venda,
            'inventarios' => $inventarios,
            'clientes' => $clientes
        ]);
    }

    public function update($id)
    {
        $vendaModel = new Venda();
        $inventarioModel = new Inventario();
        $clienteModel = new Cliente();

        $venda = $vendaModel->find($id);
        if (!$venda) {
            log_message('error', 'Venda não encontrada: ' . $id);
            return redirect()->to('/vendas')->with('error', 'Venda não encontrada.');
        }

        $vendasData = $this->request->getPost();
        $valorTotal = 0;

        if (!$clienteModel->find($vendasData['cliente_id'])) {
            log_message('error', 'Cliente não encontrado: ' . $vendasData['cliente_id']);
            return redirect()->back()->with('errors', ['Cliente não encontrado.']);
        }

        $formaDePagamento = $vendasData['forma_de_pagamento'];
        $itensVendidos = [];

        foreach ($vendasData['inventarios'] as $item) {
            $itemData = $inventarioModel->find($item['id']);
            $quantidade = $item['quantity'];

            if ($itemData) {
                log_message('info', 'Updating inventory for item: ' . $item['id'] . ', quantity: ' . $quantidade);
                $inventarioModel->update($item['id'], [
                    'quantity' => $itemData['quantity'] - $quantidade
                ]);

                $valorTotal += $itemData['price'] * $quantidade;

                $itensVendidos[] = [
                    'id' => $item['id'],
                    'name' => $itemData['name'],
                    'quantity' => $quantidade,
                    'price' => $itemData['price']
                ];
            } else {
                log_message('error', 'Item não encontrado: ' . $item['id']);
            }
        }

        $data = [
            'cliente_id' => $vendasData['cliente_id'],
            'valor_total' => $valorTotal,
            'data_venda' => date('Y-m-d H:i:s'),
            'itens_vendidos' => json_encode($itensVendidos),
            'forma_de_pagamento' => $formaDePagamento 
        ];

        $vendaModel->update($id, $data);
        log_message('info', 'Venda atualizada com sucesso: ' . json_encode($data));

        return redirect()->to('/vendas')->with('success', 'Venda atualizada com sucesso!');
    }

    public function show($id)
    {
        $vendaModel = new Venda();
        $clienteModel = new Cliente();

        $venda = $vendaModel->find($id);

        if (!$venda) {
            return redirect()->to('/vendas')->with('error', 'Venda não encontrada.');
        }

        $cliente = $clienteModel->find($venda['cliente_id']);

        if (!$cliente) {
            return redirect()->to('/vendas')->with('error', 'Cliente não encontrado.');
        }

        $itensVendidos = json_decode($venda['itens_vendidos'], true);

        return view('vendas/showVenda', [
            'venda' => $venda,
            'cliente' => $cliente,
            'itensVendidos' => $itensVendidos
        ]);
    }

    public function delete($id)
    {
        $vendaModel = new Venda();
        $venda = $vendaModel->find($id);

        if (!$venda) {
            return redirect()->to('/vendas')->with('error', 'Venda não encontrada.');
        }

        $vendaModel->delete($id);
        return redirect()->to('/vendas')->with('success', 'Venda excluída com sucesso!');
    }
}
