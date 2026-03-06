<?php
/**
 * VOX - Sistema de Ouvidoria
 * Router simples (front controller)
 */

declare(strict_types=1);

namespace Vox\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, callable|array $handler): self
    {
        $this->routes['GET'][$path] = $handler;
        return $this;
    }

    public function post(string $path, callable|array $handler): self
    {
        $this->routes['POST'][$path] = $handler;
        return $this;
    }

    public function dispatch(string $method, string $uri): void
    {
        // Debug Log
        error_log("[VOX ROUTER] Dispatching {$method} {$uri}");

        // CSRF Universal Protection
        if ($method === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if (!\Vox\Core\Session::verifyCsrf($token)) {
                error_log("[VOX ROUTER] CSRF Failure for {$uri}");
                http_response_code(403);
                die('Requisição bloqueada por motivo de segurança (CSRF token inválido/expirado). Volte, recarregue a página e tente novamente.');
            }
        }

        // Remove query string
        $uri = parse_url($uri, PHP_URL_PATH) ?: '/';
        $uri = rtrim($uri, '/') ?: '/';

        // Tratamento especial para /index.php (comum em subdiretórios ou Nginx)
        if ($uri === '/index.php') {
            $uri = '/';
        }

        $handler = $this->routes[$method][$uri] ?? null;

        if ($handler === null) {
            http_response_code(404);
            View::render('pages/erro', [
                'titulo' => 'Página não encontrada',
                'mensagem' => 'A página solicitada não existe.',
                'voltar' => '/'
            ]);
            return;
        }

        if (is_array($handler)) {
            [$class, $method] = $handler;
            $controller = new $class();
            $controller->$method();
        } else {
            $handler();
        }
    }
}
