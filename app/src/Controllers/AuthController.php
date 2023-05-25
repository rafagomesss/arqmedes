<?php

declare(strict_types=1);

namespace Arqmedes\Controllers;

use Arqmedes\Core\Controller;
use Arqmedes\Core\Session\Flash;
use Arqmedes\Core\Session\Session;
use Arqmedes\Entities\User;
use Arqmedes\Models\ModelUser;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if (
            Session::has('user')
            && $this->request->action !== 'logout'
        ) {
            $this->redirect('/home');
            exit();
        }
    }

    private function checkUserExists(string $email): bool
    {
        $user = (new ModelUser())->findByEmail($email);

        return !empty($user);
    }

    public function signin()
    {
        $data = [
            'action' => 'Login',

        ];
        return $this->render('auth/login', $data);
    }

    public function signup()
    {
        $data = [
            'action' => 'Registrar',

        ];
        return $this->render('auth/register', $data);
    }

    public function login()
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($email)) {
            Flash::set('warning', 'E-mail inválido!');
            return $this->redirect('/auth/signin');
        }

        if (empty($password)) {
            Flash::set('warning', 'O campo senha é obrigatório!');
            return $this->redirect('/auth/signin');
        }

        $user = (new ModelUser())->findByEmail($email);

        if (empty($user)) {
            Flash::set(
                'warning',
                'Usuário não encontrado!
                <b>Verifique os dados informados</b> ou faça o cadastro
                <u>
                    <a class="text-info" href="/auth/signup">clicando aqui.</a>
                </u>"'
            );
            return $this->redirect('/auth/signin');
        }

        if (!empty($password) && password_verify($password, $user->password)) {
            Flash::set('success', 'Usuário <b>' . $user->name . '</b> logado!');
            Session::set('user', $user->email);
            $this->redirect('/home');
        }
    }

    public function register()
    {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        $confirmPassword = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($email)) {
            Flash::set('warning', 'E-mail inválido!');
            return $this->redirect('/auth/signup');
        }

        if (empty($password)) {
            Flash::set('warning', 'O campo senha é obrigatório!');
            return $this->redirect('/auth/signup');
        }

        if ($this->checkUserExists($email)) {
            Flash::set('warning', 'Usuário já cadastrado, realize o Login no sistema!');
            return $this->redirect('/auth/signin');
        }

        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
        ]);

        $userCreated = (new ModelUser())->create($user);
        if (!empty($userCreated)) {
            Flash::set('success', 'Usuário ' . $userCreated->name . ' logado!');
            Session::set('user', $userCreated->email);
            $this->redirect('/home');
        }
    }

    public function logout()
    {
        Session::destroy();
        return $this->redirect('/');
    }
}
