<?php

declare(strict_types=1);

namespace Arqmedes\Core;

use Exception;

class Controller
{
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
        require_once VIEWS_INCLUDES_PATH . DIRECTORY_SEPARATOR . 'scripts.phtml';
        require_once VIEWS_INCLUDES_PATH . DIRECTORY_SEPARATOR . 'footer.phtml';

        $content = ob_get_clean();
        return $content;
    }

    public function notFound()
    {
        return self::render('notFound');
    }
}
