<?php

declare(strict_types=1);

namespace Arqmedes\Core;

class Router
{
    public function __construct(private Request $request)
    {
    }

    public function run(): void
    {
        $this->validate();
    }

    private function classExistsRouter(): bool
    {
        return class_exists($this->request->controller = "Arqmedes\Controllers\\" . $this->request->controller);
    }

    private function methodExistsRouter(): bool
    {
        return method_exists($this->request->controller, $this->request->action);
    }

    public function validate(): void
    {
        if (!$this->classExistsRouter() || !$this->methodExistsRouter()) {
            $this->request->controller = "Arqmedes\\Core\\Controller";
            $this->request->action = 'notFound';
        }

        $response = call_user_func_array(
            [new $this->request->controller, $this->request->action],
            [$this->request->args]
        );
        print $response;
    }
}
