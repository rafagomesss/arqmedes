<?php

$routes = [
    'produtos' => [
        'controller' => 'ProductController',
        'actions' => [
            '' => 'index',
            'editar' => 'edit',
            'cadastrar' => 'create',
            'registrar' => 'store',
        ],
    ],
];

define('SYSTEM_ROUTES', $routes);
