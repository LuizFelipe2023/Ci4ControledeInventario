<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\User;
use Exception;

class AuthController extends BaseController
{
    public function register()
    {
        return view('users/register');
    }

    public function createUser()
    {
        try {
            log_message('info', 'Iniciando o processo de criação de usuário.');

            $userModel = new User();


            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'confirm_password' => $this->request->getPost('confirm_password'),
            ];

            log_message('info', 'Dados recebidos para criação de usuário: ' . json_encode($data));


            $data['password'] = trim($data['password']);
            $data['confirm_password'] = trim($data['confirm_password']);


            if ($data['password'] !== $data['confirm_password']) {
                log_message('error', 'As senhas não correspondem.');
                return redirect()->back()->withInput()->with('errors', ['As senhas não correspondem.']);
            }


            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);


            if (!$userModel->save($data)) {
                log_message('error', 'Erro ao salvar o usuário: ' . json_encode($userModel->errors()));
                return redirect()->back()->withInput()->with('errors', $userModel->errors());
            }

            log_message('info', 'Usuário criado com sucesso: ' . $data['email']);
            return redirect()->to('/login')->with('message', 'Usuário criado com sucesso!');
        } catch (Exception $e) {
            log_message('error', 'Erro ao criar o usuário: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro ao criar o usuário.');
        }
    }



    public function login()
    {
        return view('users/login');
    }

    public function authenticate()
    {
        try {
            log_message('info', 'Iniciando o processo de autenticação.');

            $userModel = new User();
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            log_message('info', 'Dados recebidos para autenticação: Email = ' . $email);

          
            $user = $userModel->where('email', $email)->first();

            if ($user && password_verify($password, $user['password'])) {
                log_message('info', 'Autenticação bem-sucedida. Configurando a sessão.');

            
                session()->set([
                    'user_id'   => $user['id'],
                    'user_name' => $user['name'],
                    'loggedIn'  => true,
                ]);

                
                log_message('info', 'Sessão configurada: ' . json_encode(session()->get()));

                return redirect()->to('/inventario')->with('message', 'Login realizado com sucesso!');
            } else {
                log_message('error', 'Falha na autenticação: Credenciais inválidas.');
                return redirect()->back()->withInput()->with('error', 'Credenciais inválidas.');
            }
        } catch (Exception $e) {
            log_message('error', 'Erro ao processar o login: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro ao processar o login.');
        }
    }



    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('message', 'Você foi desconectado.');
    }
}
