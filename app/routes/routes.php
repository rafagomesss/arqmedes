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
        ],
    ],
];

define('SYSTEM_ROUTES', $routes);
