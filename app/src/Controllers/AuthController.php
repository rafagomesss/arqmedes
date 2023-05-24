<?php

declare(strict_types=1);

namespace Arqmedes\Controllers;

use Arqmedes\Core\Controller;
use Arqmedes\Core\Session\Session;

class AuthController extends Controller
{
    public function __construct()
    {
        if (!Session::has('user')) {
            $this->redirect('/auth/signin');
            exit;
        }
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

    }

    public function register()
    {

    }
}