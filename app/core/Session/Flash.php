<?php

declare(strict_types=1);

namespace Arqmedes\Core\Session;

class Flash
{
    public static function set(string $key, string $message)
    {
        Session::set($key, $message);
    }

    public static function get($key): string
    {
        $message = Session::get($key);
        Session::delete($key);
        return $message;
    }

    public static function hasFlashMessage(): string|bool
    {
        if (!empty($_SESSION)) {
            foreach (array_keys($_SESSION) as $key) {
                if (in_array($key, ALERT_TYPES)) {
                    return $key;
                }
            }
        }
        return false;
    }
}
