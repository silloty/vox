<?php
/**
 * VOX - Sistema de Ouvidoria
 * Camada de Conexão com o Banco de Dados (PDO)
 * 
 * Substitui a classe gtiConexao que usava ADODB5
 * Mantém a mesma interface lógica: conectar, executar SQL, preencher tabela/array
 */

declare(strict_types=1);

namespace Vox\Core;

use PDO;
use PDOException;
use PDOStatement;
use Vox\Config\AppConfig;

class Database
{
    private static ?Database $instance = null;
    private ?PDO $connection = null;
    private AppConfig $config;

    private function __construct()
    {
        $this->config = AppConfig::getInstance();
        $this->connect();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect(): void
    {
        try {
            $dsn = sprintf(
                'pgsql:host=%s;port=%d;dbname=%s',
                $this->config->dbHost,
                $this->config->dbPort,
                $this->config->dbName
            );

            $this->connection = new PDO($dsn, $this->config->dbUser, $this->config->dbPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => false,
            ]);

            // Definir schema se necessário
            if ($this->config->dbSchema !== 'public') {
                $this->connection->exec("SET search_path TO {$this->config->dbSchema}, public");
            }
        } catch (PDOException $e) {
            throw new \RuntimeException("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            $this->connect();
        }
        return $this->connection;
    }

    /**
     * Executa uma query com prepared statement (INSERT, UPDATE, DELETE)
     */
    public function execute(string $sql, array $params = []): PDOStatement
    {
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new \RuntimeException("Erro ao executar SQL: " . $e->getMessage());
        }
    }

    /**
     * Busca todos os registros (equivalente ao gtiPreencheArray)
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->execute($sql, $params);
        return $stmt->fetchAll();
    }

    /**
     * Busca um único registro
     */
    public function fetchOne(string $sql, array $params = []): array|false
    {
        $stmt = $this->execute($sql, $params);
        return $stmt->fetch();
    }

    /**
     * Busca um valor escalar (count, max, etc)
     */
    public function fetchColumn(string $sql, array $params = []): mixed
    {
        $stmt = $this->execute($sql, $params);
        return $stmt->fetchColumn();
    }

    /**
     * Retorna o último ID inserido
     */
    public function lastInsertId(string $name = ''): string
    {
        return $this->getConnection()->lastInsertId($name);
    }

    /**
     * Inicia uma transação
     */
    public function beginTransaction(): void
    {
        $this->getConnection()->beginTransaction();
    }

    /**
     * Confirma a transação
     */
    public function commit(): void
    {
        $this->getConnection()->commit();
    }

    /**
     * Desfaz a transação
     */
    public function rollback(): void
    {
        $this->getConnection()->rollBack();
    }

    /**
     * Reseta a instância (usado em testes)
     */
    public static function reset(): void
    {
        if (self::$instance !== null) {
            self::$instance->connection = null;
            self::$instance = null;
        }
    }
}
