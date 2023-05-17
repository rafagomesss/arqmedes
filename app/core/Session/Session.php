<?php

declare(strict_types=1);

namespace Arqmedes\Core\Session;

class Session
{
    public function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            return session_start();
        }
    }

    public static function get(string $key): ?string
    {
        return $_SESSION[$key] ?? null;
    }

    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function delete(string $key)
    {
        unset($_SESSION[$key]);
    }

    public static function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public static function destroy()
    {
        session_destroy();
    }
}
