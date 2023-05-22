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
        ],
    ],
];

define('SYSTEM_ROUTES', $routes);
