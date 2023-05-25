<?php

declare(strict_types=1);

namespace Arqmedes\Core;

// use System\Session\Session;

class Request
{
    public function __construct(
        public string $controller = DEFAULT_CONTROLLER,
        public string $action = DEFAULT_ACTION,
        public $args = []
    ) {
        $uri = parse_url(substr($_SERVER['REQUEST_URI'], 1), PHP_URL_PATH);
        $uri = explode('/', $uri);

        $this->defineRequestTranslated($uri);
    }

    private function defineRequestTranslated(array $uri)
    {
        $controller = array_shift($uri);
        $action = array_shift($uri);

        $translatedController = SYSTEM_ROUTES[$controller]['controller'] ?? $controller ?? DEFAULT_CONTROLLER;
        $this->setController($translatedController);

        $translatedAction = SYSTEM_ROUTES[$controller]['actions'][$action] ?? $action ?? DEFAULT_ACTION;

        $this->setAction($translatedAction);

        $this->setArgs($uri);
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function setAction(?string $action)
    {
        $action = empty($action)
        ? DEFAULT_ACTION
        : $action;
        $this->action = $action;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setController(?string $controller)
    {
        $path = "Arqmedes\Controllers\\";

        $fullController = $path . DEFAULT_CONTROLLER;
        if (!empty($controller)) {
            $fullController = $path . ucfirst($controller) . 'Controller';
        }

        $this->controller = $fullController;
    }

    public function setArgs(?array $args)
    {
        if (
            !empty($args)
            && is_array($args)
        ) {
            $args = count($args) === 1 ? current($args) : $args;
        }
        $this->args = $args;
    }
}
