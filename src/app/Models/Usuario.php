<?php
/**
 * VOX - Sistema de Ouvidoria
 * Model: Usuário
 * 
 * Preserva a mesma lógica do usuario.cls.php original
 * Modernizado com PHP 8.2, PDO e password_hash
 */

declare(strict_types=1);

namespace Vox\Models;

use Vox\Core\Database;

class Usuario
{
    public ?int $codigo = null;
    public string $login = '';
    public string $senha = '';
    public string $nome = '';

    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Autentica um usuário (equivalente ao Autentica original)
     */
    public function autentica(string $login, string $senha): bool
    {
        $row = $this->db->fetchOne(
            'SELECT * FROM public.usuario WHERE login = :login',
            ['login' => trim($login)]
        );

        if (!$row) {
            return false;
        }

        // Verifica senha com password_verify (hash moderno)
        if (password_verify($senha, $row['senha'])) {
            $this->codigo = (int) $row['usuario_id'];
            $this->login = $row['login'];
            $this->nome = $row['nome'];
            return true;
        }

        // Compatibilidade com senha legada (MD5)
        if (md5($senha) === $row['senha']) {
            $this->codigo = (int) $row['usuario_id'];
            $this->login = $row['login'];
            $this->nome = $row['nome'];

            // Atualiza para hash moderno
            $this->db->execute(
                'UPDATE public.usuario SET senha = :senha WHERE usuario_id = :id',
                ['senha' => password_hash($senha, PASSWORD_DEFAULT), 'id' => $this->codigo]
            );
            return true;
        }

        return false;
    }

    /**
     * Seleciona por código
     */
    public function selecionaPorCodigo(int $codigo): bool
    {
        $row = $this->db->fetchOne(
            'SELECT usuario_id, login, senha, nome FROM public.usuario WHERE usuario_id = :id',
            ['id' => $codigo]
        );

        if ($row) {
            $this->codigo = (int) $row['usuario_id'];
            $this->login = $row['login'];
            $this->senha = $row['senha'];
            $this->nome = $row['nome'];
            return true;
        }
        return false;
    }

    /**
     * Excluir usuário
     */
    public function excluir(int $codigo): void
    {
        $this->db->execute(
            'DELETE FROM public.usuario WHERE usuario_id = :id',
            ['id' => $codigo]
        );
    }

    /**
     * Alterar usuário
     */
    public function alterar(): void
    {
        $params = [
            'login' => $this->login,
            'nome' => $this->nome,
            'id' => $this->codigo,
        ];

        $setSenha = '';
        if (!empty($this->senha)) {
            $setSenha = ', senha = :senha';
            $params['senha'] = password_hash($this->senha, PASSWORD_DEFAULT);
        }

        $this->db->execute(
            "UPDATE public.usuario SET login = :login, nome = :nome{$setSenha} WHERE usuario_id = :id",
            $params
        );
    }

    /**
     * Salvar novo usuário
     */
    public function salvar(): void
    {
        $this->db->execute(
            'INSERT INTO public.usuario (login, senha, nome) VALUES (:login, :senha, :nome)',
            [
                'login' => $this->login,
                'senha' => password_hash($this->senha, PASSWORD_DEFAULT),
                'nome' => $this->nome,
            ]
        );
    }

    /**
     * Lista todos os usuários
     */
    public function listaUsuarioArray(): array
    {
        return $this->db->fetchAll(
            'SELECT * FROM public.usuario ORDER BY nome'
        );
    }
}
