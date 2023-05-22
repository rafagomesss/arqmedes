<?php

use Arqmedes\Core\Session\Session;


require_once dirname($_SERVER['DOCUMENT_ROOT']) . DIRECTORY_SEPARATOR . 'bootstrap.php';

use Arqmedes\Core\{
    Router,
    Request,
};

$session = (new Session());
$session->start();

$app = (new Router(new Request()));
$app->run();
