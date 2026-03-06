<?php
/**
 * VOX - Sistema de Ouvidoria
 * Configuração da Aplicação
 * 
 * Carrega variáveis de ambiente do .env ou do Docker
 */

declare(strict_types=1);

namespace Vox\Config;

class AppConfig
{
    private static ?AppConfig $instance = null;

    // Banco de Dados
    public readonly string $dbHost;
    public readonly int $dbPort;
    public readonly string $dbName;
    public readonly string $dbUser;
    public readonly string $dbPass;
    public readonly string $dbSchema;

    // Aplicação
    public readonly string $appName;
    public readonly string $appUrl;
    public readonly string $appEnv;
    public readonly string $appInstitution;

    // Email
    public readonly string $mailHost;
    public readonly int $mailPort;
    public readonly string $mailUsername;
    public readonly string $mailPassword;
    public readonly string $mailFromAddress;
    public readonly string $mailAdminAddress;

    // Manifestação
    public readonly int $maxCharsManifestacao;

    private function __construct()
    {
        $this->dbHost = $this->env('DB_HOST', 'localhost');
        $this->dbPort = (int) $this->env('DB_PORT', '5432');
        $this->dbName = $this->env('DB_NAME', 'vox');
        $this->dbUser = $this->env('DB_USER', 'usrvox');
        $this->dbPass = $this->env('DB_PASS', '');
        $this->dbSchema = $this->env('DB_SCHEMA', 'public');

        $this->appName = $this->env('APP_NAME', 'VOX - Sistema de Ouvidoria');
        $this->appUrl = $this->env('APP_URL', 'http://localhost:8080');
        $this->appEnv = $this->env('APP_ENV', 'production');
        $this->appInstitution = $this->env('APP_INSTITUTION', '');

        $this->mailHost = $this->env('MAIL_HOST', '');
        $this->mailPort = (int) $this->env('MAIL_PORT', '587');
        $this->mailUsername = $this->env('MAIL_USERNAME', '');
        $this->mailPassword = $this->env('MAIL_PASSWORD', '');
        $this->mailFromAddress = $this->env('MAIL_FROM_ADDRESS', '');
        $this->mailAdminAddress = $this->env('MAIL_ADMIN_ADDRESS', '');

        $this->maxCharsManifestacao = (int) $this->env('MAX_CHARS_MANIFESTACAO', '2000');
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function env(string $key, string $default = ''): string
    {
        return $_ENV[$key] ?? getenv($key) ?: $default;
    }

    public function isProduction(): bool
    {
        return $this->appEnv === 'production';
    }

    public function isDevelopment(): bool
    {
        return $this->appEnv === 'development';
    }
}
