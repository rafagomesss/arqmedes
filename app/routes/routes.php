<?php

$routes = [
    'produtos' => [
        'controller' => 'ProductController',
        'actions' => [
            '' => 'index',
            'editar' => 'edit',
            'cadastrar' => 'create',
            'registrar' => 'store',
            'detalhes' => 'show',
            'excluir' => 'delete',
            'atualizar' => 'update',
        ],
    ],
    'categorias' => [
        'controller' => 'CategoryController',
        'actions' => [
            '' => 'index',
            'editar' => 'edit',
            'cadastrar' => 'create',
            'registrar' => 'store',
            'detalhes' => 'show',
            'excluir' => 'delete',
            'atualizar' => 'update',
        ],
    ],
    'auth' => [
        'controller' => 'AuthController',
        'actions' => [
            'login' => 'login',
            'registrar' => 'register',
            'signin' => 'signin'
        ],
    ],
];

define('SYSTEM_ROUTES', $routes);
