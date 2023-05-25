<?php

$routes = [
    'produtos' => [
        'controller' => 'Product',
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
        'controller' => 'Category',
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
        'controller' => 'Auth',
        'actions' => [
            'login' => 'login',
            'registrar' => 'register',
            'signin' => 'signin',
            'signup' => 'signup',
            'logout' => 'logout',
        ],
    ],
];

define('SYSTEM_ROUTES', $routes);
