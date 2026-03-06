<?php
/**
 * VOX - Sistema de Ouvidoria
 * Renderizador de Views
 */

declare(strict_types=1);

namespace Vox\Core;

use Vox\Config\AppConfig;

class View
{
    /**
     * Renderiza uma view com layout
     */
    public static function render(string $view, array $data = [], string $layout = 'main'): void
    {
        $config = AppConfig::getInstance();
        $data['config'] = $config;
        $data['session'] = new class {
            public function isLoggedIn(): bool
            {
                return Session::isLoggedIn();
            }
            public function getUserNome(): string
            {
                return Session::getUserNome();
            }
            public function getFlash(string $key): ?string
            {
                return Session::getFlash($key);
            }
        };

        extract($data);

        $viewPath = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View não encontrada: {$view}");
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        $layoutPath = __DIR__ . '/../Views/layouts/' . $layout . '.php';

        if (file_exists($layoutPath)) {
            $pageTitle = $data['pageTitle'] ?? 'VOX - Sistema de Ouvidoria';
            ob_start();
            require $layoutPath;
            $finalOutput = ob_get_clean();
        } else {
            $finalOutput = $content;
        }

        // Inclusão universal e automática de token CSRF
        $csrfToken = Session::csrf();
        $finalOutput = preg_replace(
            '/(<form\b[^>]*method=["\']post["\'][^>]*>)/i',
            '$1<input type="hidden" name="csrf_token" value="' . $csrfToken . '">',
            $finalOutput
        );

        echo $finalOutput;
    }

    /**
     * Renderiza uma view sem layout (para modais, fragments, etc)
     */
    public static function renderPartial(string $view, array $data = []): void
    {
        extract($data);
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require $viewPath;
        }
    }

    /**
     * Renderiza parcial e retorna como string
     */
    public static function capture(string $view, array $data = []): string
    {
        ob_start();
        self::renderPartial($view, $data);
        return ob_get_clean();
    }

    /**
     * Escapa HTML para prevenir XSS
     */
    public static function e(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}
