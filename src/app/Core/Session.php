<?php
/**
 * VOX - Sistema de Ouvidoria
 * Gerenciador de Sessão
 */

declare(strict_types=1);

namespace Vox\Core;

class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_name('VOX_SESSION');
            session_start();
        }
    }

    public static function regenerate(): void
    {
        self::start();
        session_regenerate_id(true);
    }

    public static function csrf(): string
    {
        self::start();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCsrf(string $token): bool
    {
        self::start();
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function set(string $key, mixed $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    public static function destroy(): void
    {
        self::start();
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        session_destroy();
    }

    public static function isLoggedIn(): bool
    {
        return self::has('vox_user_id') && !empty(self::get('vox_user_id'));
    }

    public static function setUser(int $id, string $nome, string $login): void
    {
        self::set('vox_user_id', $id);
        self::set('vox_user_nome', $nome);
        self::set('vox_user_login', $login);
    }

    public static function getUserId(): ?int
    {
        $id = self::get('vox_user_id');
        return $id !== null ? (int) $id : null;
    }

    public static function getUserNome(): string
    {
        return (string) self::get('vox_user_nome', '');
    }

    public static function flash(string $key, string $message): void
    {
        self::set("flash_{$key}", $message);
    }

    public static function getFlash(string $key): ?string
    {
        $value = self::get("flash_{$key}");
        self::remove("flash_{$key}");
        return $value;
    }
}
