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

        $clienteId = $vendasData['cliente_id'];
        $itens = $vendasData['inventarios'];
        $valorTotal = 0;

        if (!$clienteModel->find($clienteId)) {
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
                    return redirect()->back()->with('errors', ['Quantidade insuficiente para o item: ' . $itemData['name']]);
                }
            }
        }

        $data = [
            'cliente_id' => $clienteId,
            'valor_total' => $valorTotal,
            'data_venda' => date('Y-m-d H:i:s'),
            'itens_vendidos' => json_encode($itensVendidos)
        ];

        if (!$vendaModel->save($data)) {
            return redirect()->back()->with('errors', ['Erro ao registrar a venda.']);
        }

        return redirect()->to('/vendas')->with('success', 'Vendas registradas com sucesso!');
    }


    public function edit($id)
    {
        $vendaModel = new Venda();
        $inventarioModel = new Inventario();
        $clienteModel = new Cliente();
    
        $venda = $vendaModel->find($id);
        $inventarios = $inventarioModel->findAll();  // Corrigi para '$inventarios'
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
            return redirect()->to('/vendas')->with('error', 'Venda não encontrada.');
        }

        $vendasData = $this->request->getPost();
        $valorTotal = 0;

        if (!$clienteModel->find($vendasData['cliente_id'])) {
            return redirect()->back()->with('errors', ['Cliente não encontrado.']);
        }

        $itensVendidos = [];

        foreach ($vendasData['inventarios'] as $item) {
            $itemData = $inventarioModel->find($item['id']);
            $quantidade = $item['quantity'];

            if ($itemData) {
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
            }
        }

        $data = [
            'cliente_id' => $vendasData['cliente_id'],
            'valor_total' => $valorTotal,
            'data_venda' => date('Y-m-d H:i:s'),
            'itens_vendidos' => json_encode($itensVendidos)
        ];

        $vendaModel->update($id, $data);
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
