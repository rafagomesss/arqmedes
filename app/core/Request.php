<?php

declare(strict_types=1);

namespace Arqmedes\Core;

// use System\Session\Session;

class Request
{
    public function __construct(
        public string $controller = DEFAULT_CONTROLLER,
        public string $action = DEFAULT_ACTION,
        public array $args = []
    ) {
        $uri = parse_url(substr($_SERVER['REQUEST_URI'], 1), PHP_URL_PATH);
        $uri = explode('/', $uri);

        $this->setController(array_shift($uri));
        $this->action = array_shift($uri) ?: DEFAULT_ACTION;
        $this->args = $uri ?? [];
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function setController(?string $controller)
    {
        $controller = empty($controller)
            ? DEFAULT_CONTROLLER
            : (ucfirst($controller) . 'Controller');
        $this->controller = $controller;
    }

}