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
                'isVerified' => 0
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
            return redirect()->to('/')->with('message', 'Usuário criado com sucesso!');
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
                log_message('info', 'Autenticação bem-sucedida.');

                if ($user['isVerified'] == 0) {
                    log_message('warning', 'Usuário não verificado, redirecionando para a verificação de e-mail.');

                    return redirect()->to('/verify-email')->with('warning', 'Por favor, verifique seu e-mail antes de continuar.');
                }

                log_message('info', 'Configuring session for verified user.');

                session()->set([
                    'user_id'   => $user['id'],
                    'user_name' => $user['name'],
                    'isVerified' => $user['isVerified'],
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



    public function verifyEmail()
    {
        return view('users/verify-email');
    }

    public function sendVerificationEmail()
    {
        $email = $this->request->getPost('email');
        $userModel = new User();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email não encontrado.');
        }

        $token = strtoupper(substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6));
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);

        if (!$userModel->update($user['id'], ['token' => $hashedToken])) {
            log_message('error', 'Erro ao atualizar o token para o usuário: ' . json_encode($user));
            return redirect()->back()->with('error', 'Erro ao atualizar o token.');
        }

        // Store token in session
        session()->set('verification_token', $token);
        session()->set('user_id', $user['id']);

        // Send email
        if ($this->sendEmail($email)) {
            return redirect()->to('/')->with('message', 'Verificação enviada! Verifique seu email.');
        }

        log_message('error', 'Falha ao enviar o email de verificação para: ' . $email);
        return redirect()->back()->with('error', 'Falha ao enviar o email de verificação.');
    }

    private function sendEmail($email)
    {
        $emailService = \Config\Services::email();
        $emailService->setFrom('felipinhoneves2011@gmail.com', 'Luiz Felipe Frois Neves');
        $emailService->setTo($email);
        $emailService->setSubject('Verificação de Email');

        $emailBody = "<p>Clique no link abaixo para verificar seu email:</p>";
        $emailBody .= "<p><a href='" . site_url('verify-token') . "'>Verificar Email</a></p>";
        $emailBody .= "<p>Use o seguinte código de verificação:</p>";
        $emailBody .= "<p><strong>" . esc(session()->get('verification_token')) . "</strong></p>";

        $emailService->setMessage($emailBody);
        $emailService->setMailType('html');

        return $emailService->send();
    }

    public function verifyToken()
    {
        return view('users/verify-token');
    }

    public function validateToken()
    {
        $token = $this->request->getPost('token');
        $storedToken = session()->get('verification_token');
        $userId = session()->get('user_id');

        log_message('info', 'Token recebido para validação: ' . $token);

        if (password_verify($token, password_hash($storedToken, PASSWORD_DEFAULT))) {
            $userModel = new User();
            $userModel->update($userId, ['isVerified' => 1, 'token' => null]);

            session()->remove('verification_token');
            session()->remove('user_id');

            return redirect()->to('/')->with('message', 'Email verificado com sucesso!');
        }

        log_message('error', 'Token inválido ou expirado: ' . $token);
        return redirect()->to('/')->with('error', 'Token inválido ou expirado.');
    }






    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('message', 'Você foi desconectado.');
    }
}
