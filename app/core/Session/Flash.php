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
}
