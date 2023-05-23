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
];

define('SYSTEM_ROUTES', $routes);
