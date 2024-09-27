<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Cliente;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class ClienteController extends BaseController
{
    public function home()
    {
        $clienteModel  = new Cliente();

        $clientes = $clienteModel->orderBy('id', 'ASC')->findAll();

        return view('clientes/home', ['clientes' => $clientes]);
    }

    public function createCliente()
    {
        return view('clientes/createCliente');
    }

    public function insertCliente()
    {
        try {
            $clienteModel = new Cliente();

            $file = $this->request->getFile('imagem');
            $imagePath = null;
            if ($file && $file->isValid()) {
                $newFilename = $file->getClientName();
                if ($file->move(FCPATH . 'uploads', $newFilename)) {
                    $imagePath = 'uploads/' . $newFilename;
                }
            }

            $data = [
                'nome' => $this->request->getPost('nome'),
                'endereco' => $this->request->getPost('endereco'),
                'cpf' => $this->request->getPost('cpf'),
                'telefone' => $this->request->getPost('telefone'),
                'email' => $this->request->getPost('email'),
                'imagem' => $imagePath
            ];

            if (!$clienteModel->insert($data)) {
                return redirect()->back()->withInput()->with('errors', $clienteModel->errors());
            }

            return redirect()->to('/clientes')->with('success', 'Cliente inserido com sucesso.');
        } catch (\Exception $e) {
            log_message('error', 'Error inserting client: ' . $e->getMessage());
            return redirect()->back()->with('errors', 'Houve um erro inesperado. Tente novamente.');
        }
    }


    public function showCliente($id)
    {
        $clienteModel = new Cliente();

        $cliente = $clienteModel->find($id);

        if (!$cliente) {
            return redirect()->back()->with('errors', 'Não foi encontrado nenhum cliente');
        }

        return view('clientes/showCliente', ['cliente' => $cliente]);
    }

    public function editCliente($id)
    {
        $clienteModel = new Cliente();


        $cliente = $clienteModel->find($id);

        if (!$cliente) {
            return redirect()->back()->with('errors', 'Não foi encontrado nenhum cliente para editar');
        }

        return view('clientes/editCliente', ['cliente' => $cliente]);
    }

    public function updateCliente($id)
    {
        try {
            $clienteModel = new Cliente();

            $cliente = $clienteModel->find($id);

            if (!$cliente) {
                return redirect()->back()->with('errors', 'Não foi encontrado nenhum cliente para atualizar');
            }

            $file = $this->request->getFile('imagem');
            $imagePath = $cliente['imagem']; 
            if ($file && $file->isValid()) {
                $newFilename = $file->getClientName();
                if ($file->move(FCPATH . 'uploads', $newFilename)) {
                    $imagePath = 'uploads/' . $newFilename;
                }
            }

            $data = [
                'nome' => $this->request->getPost('nome'),
                'endereco' => $this->request->getPost('endereco'),
                'cpf' => $this->request->getPost('cpf'),
                'telefone' => $this->request->getPost('telefone'),
                'email' => $this->request->getPost('email'),
                'imagem' => $imagePath
            ];

            if (!$clienteModel->update($id, $data)) {
                return redirect()->back()->withInput()->with('errors', $clienteModel->errors());
            }

            return redirect()->to('/clientes')->with('success', 'Cliente atualizado com sucesso.');
        } catch (\Exception $e) {
            log_message('error', 'Error updating client: ' . $e->getMessage());
            return redirect()->back()->with('errors', 'Houve um erro inesperado. Tente novamente.');
        }
    }

    public function deleteCliente($id)
    {
        try {
            $clienteModel = new Cliente();

            if (!$clienteModel->find($id)) {
                return redirect()->back()->with('errors', 'Não foi encontrado nenhum cliente para excluir');
            }

            if (!$clienteModel->delete($id)) {
                return redirect()->back()->with('errors', 'Erro ao excluir o cliente. Tente novamente.');
            }

            return redirect()->to('/clientes')->with('success', 'Cliente excluído com sucesso.');
        } catch (\Exception $e) {
            log_message('error', 'Error deleting client: ' . $e->getMessage());
            return redirect()->back()->with('errors', 'Houve um erro inesperado. Tente novamente.');
        }
    }
}
