<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Inventario;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;


use Exception;

class InventarioController extends BaseController
{
   
    public function index()
    {
        $inventario = new Inventario();

        $inventarios = $inventario->orderBy('id', 'ASC')->findAll();

        return view('inventario/index', ['inventarios' => $inventarios]);
    }

    public function createInventario()
    {
        return view('inventario/create');
    }

    public function insertInventario()
    {
        try {
            $inventariosData = $this->request->getPost('inventarios');

            log_message('info', 'Dados recebidos: ' . json_encode($inventariosData));

            $inventarioModel = new Inventario();
            $successCount = 0;
            $errors = [];

            foreach ($inventariosData as $index => $inventarioData) {
                log_message('info', 'Processando item: ' . json_encode($inventarioData));


                if (
                    empty($inventarioData['name']) ||
                    empty($inventarioData['quantity']) ||
                    empty($inventarioData['price']) ||
                    empty($inventarioData['category'])
                ) {
                    $errors[] = 'Todos os campos são obrigatórios para o item ' . ($index + 1) . '.';
                    log_message('error', 'Erro: ' . end($errors));
                    continue;
                }


                if ((int)$inventarioData['quantity'] <= 0) {
                    $errors[] = 'A quantidade deve ser maior que zero para ' . esc($inventarioData['name']) . '.';
                    log_message('error', 'Erro: ' . end($errors)); 
                    continue;
                }


                if ((float)$inventarioData['price'] < 0) {
                    $errors[] = 'O preço não pode ser negativo para ' . esc($inventarioData['name']) . '.';
                    log_message('error', 'Erro: ' . end($errors)); 
                    continue;
                }

                $file = $this->request->getFile("inventarios.$index.imagem");
                log_message('info', 'Arquivo recebido: ' . ($file ? $file->getName() : 'nenhum arquivo')); 
                
                $imagePath = null;
                
                if ($file && $file->isValid()) {
                    try {
                        $originalFileName = $file->getClientName(); 
                        $imagePath = $file->store('uploads', $originalFileName);
                        log_message('info', 'Imagem armazenada em: ' . $imagePath);
                    } catch (\CodeIgniter\Files\Exceptions\FileException $e) {
                        $errors[] = 'Erro ao enviar a imagem para o item ' . esc($inventarioData['name']) . ': ' . $e->getMessage();
                        log_message('error', 'Erro ao enviar a imagem para o item: ' . esc($inventarioData['name']) . ' - ' . $e->getMessage());
                    }
                } else {
                    $errors[] = 'Erro ao enviar a imagem para o item ' . esc($inventarioData['name']) . '.';
                    log_message('error', 'Erro ao enviar a imagem para o item: ' . esc($inventarioData['name']));
                }






                $data = [
                    'name' => $inventarioData['name'],
                    'quantity' => (int)$inventarioData['quantity'],
                    'price' => (float)$inventarioData['price'],
                    'category' => $inventarioData['category'],
                    'imagem' => $imagePath
                ];


                if ($inventarioModel->insert($data)) {
                    $successCount++;
                    log_message('info', 'Item inserido com sucesso: ' . esc($inventarioData['name']));
                } else {
                    $errors[] = 'Erro ao inserir o item ' . esc($inventarioData['name']) . '.';
                    log_message('error', 'Erro ao inserir: ' . esc($inventarioData['name']));
                }
            }


            if ($successCount > 0) {
                return redirect()->to('/inventario')->with('success', "$successCount inventários inseridos com sucesso!");
            }

            return redirect()->back()->with('error', implode(' ', $errors));
        } catch (\Exception $e) {
            log_message('error', 'Exceção capturada: ' . $e->getMessage()); // Log da exceção
            return redirect()->back()->with('error', 'Erro ao inserir os inventários.');
        }
    }




    public function editInventario($id)
    {
        $inventarioModel = new Inventario();
        $inventario = $inventarioModel->find($id);

        if (!$inventario) {
            return redirect()->back()->with('error', 'Não foi encontrado o inventário');
        }

        return view('inventario/edit', ['inventario' => $inventario]);
    }

    public function updateInventario($id)
    {
        try {
            $inventarioModel = new Inventario();

            $data = [
                'name' => $this->request->getPost('name'),
                'quantity' => (int)$this->request->getPost('quantity'),
                'price' => (float)$this->request->getPost('price'),
                'category' => $this->request->getPost('category')
            ];

            $inventarioModel->update($id, $data);

            return redirect()->to('/inventario')->with('success', 'Inventário atualizado com sucesso!');
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao atualizar o inventário: ' . $e->getMessage());
        }
    }

    public function deleteInventario($id)
    {
        try {
            $inventarioModel = new Inventario();
            $inventarioExists = $inventarioModel->find($id);

            if ($inventarioExists) {
                $inventarioModel->delete($id);
                return redirect()->to('/inventario')->with('success', 'Inventário deletado com sucesso!');
            } else {
                return redirect()->back()->with('error', 'Inventário não encontrado.');
            }
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao deletar o inventário: ' . $e->getMessage());
        }
    }
}
