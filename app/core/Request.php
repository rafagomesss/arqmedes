<?php

declare(strict_types=1);

namespace Arqmedes\Core;

// use System\Session\Session;

class Request
{
    public function __construct(
        public string $controller = DEFAULT_CONTROLLER,
        public string $action = DEFAULT_ACTION,
        public ?array $args = []
    ) {
        $uri = parse_url(substr($_SERVER['REQUEST_URI'], 1), PHP_URL_PATH);
        $uri = explode('/', $uri);

        $this->defineRequestTranslated($uri);
    }

    private function defineRequestTranslated(array $uri)
    {
        $controller = array_shift($uri);
        $action = array_shift($uri);

        $translatedController = !empty(SYSTEM_ROUTES[$controller])
            ? SYSTEM_ROUTES[$controller]['controller']
            : DEFAULT_CONTROLLER;
        $this->setController($translatedController);

        $translatedAction = !empty(SYSTEM_ROUTES[$controller])
            ? SYSTEM_ROUTES[$controller]['actions'][$action]
            : DEFAULT_ACTION;

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

    public function setController(?string $controller)
    {
        $controller = empty($controller)
            ? DEFAULT_CONTROLLER
            : $controller;
        $this->controller = $controller;
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
