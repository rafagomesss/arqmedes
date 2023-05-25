<?php

declare(strict_types=1);

namespace Arqmedes\Core;

class Controller
{
    protected string $activeController = 'home';

    protected Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    protected function redirect(string $uri)
    {
        header('Location: ' . $this->getBaseUrl() . $uri);
        exit();
    }

    protected function getBaseUrl(): string
    {
        $base = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? 'https://' : 'http://';
        $base .= $_SERVER['SERVER_NAME'];
        if ($_SERVER['SERVER_PORT'] != '80') {
            $base .= ':' . $_SERVER['SERVER_PORT'];
        }
        $base .= BASE_DIR;

        return $base;
    }

    protected function render(
        string $view,
        array $data = [],
    ): bool|string {
        $view = VIEWS_PATH . DIRECTORY_SEPARATOR . $view . '.phtml';

        if (!file_exists($view)) {
            return $this->notFound();
        }

        ob_start();
        extract($data);

        require_once VIEWS_INCLUDES_PATH . DIRECTORY_SEPARATOR . 'header.phtml';
        require_once $view;
        require_once VIEWS_INCLUDES_PATH . DIRECTORY_SEPARATOR . 'footer.phtml';

        $content = ob_get_clean();
        return $content;
    }

    public function notFound()
    {
        return self::render('notFound');
    }
}
