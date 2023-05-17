<?php

declare(strict_types=1);

namespace Arqmedes\Controllers;

use Arqmedes\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Home',
            'content' => 'Olá mundo!'
        ];
        return $this->render('home/index', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'Sobre nós',
            'content' => 'Somos uma empresa líder no mercado'
        ];
        return $this->render('home/about', $data);
    }
}

