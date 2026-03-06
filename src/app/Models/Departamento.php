<?php
/**
 * VOX - Sistema de Ouvidoria
 * Model: Departamento
 * 
 * Preserva a mesma lógica do departamento.cls.php original
 */

declare(strict_types=1);

namespace Vox\Models;

use Vox\Core\Database;

class Departamento
{
    public ?int $codigo = null;
    public string $nome = '';
    public string $email = '';
    public string $descricao = '';

    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function selecionaPorCodigo(int $codigo): bool
    {
        $row = $this->db->fetchOne(
            'SELECT departamento_id, nome, email, descricao FROM public.departamento WHERE departamento_id = :id',
            ['id' => $codigo]
        );

        if ($row) {
            $this->codigo = (int) $row['departamento_id'];
            $this->nome = $row['nome'];
            $this->email = $row['email'] ?? '';
            $this->descricao = $row['descricao'] ?? '';
            return true;
        }
        return false;
    }

    public function excluir(int $codigo): void
    {
        $this->db->execute(
            'DELETE FROM public.departamento WHERE departamento_id = :id',
            ['id' => $codigo]
        );
    }

    public function alterar(): void
    {
        $this->db->execute(
            'UPDATE public.departamento SET nome = :nome, email = :email, descricao = :descricao WHERE departamento_id = :id',
            [
                'nome' => $this->nome,
                'email' => $this->email,
                'descricao' => $this->descricao,
                'id' => $this->codigo,
            ]
        );
    }

    public function salvar(): void
    {
        $this->db->execute(
            'INSERT INTO public.departamento (nome, email, descricao) VALUES (:nome, :email, :descricao)',
            [
                'nome' => $this->nome,
                'email' => $this->email,
                'descricao' => $this->descricao,
            ]
        );
    }

    public function listaDepartamentoArray(): array
    {
        return $this->db->fetchAll('SELECT * FROM departamento ORDER BY nome');
    }

    public function filtraDepartamentoArray(string $valor): array
    {
        return $this->db->fetchAll(
            'SELECT * FROM departamento WHERE LOWER(nome) LIKE :valor ORDER BY nome',
            ['valor' => '%' . mb_strtolower($valor) . '%']
        );
    }

    /**
     * Retorna opções HTML para combo (preserva lógica original)
     */
    public function listaCombo(): string
    {
        $departamentos = $this->listaDepartamentoArray();
        $html = '';
        foreach ($departamentos as $d) {
            $html .= '<option value="' . $d['departamento_id'] . '">' . htmlspecialchars($d['nome']) . '</option>';
        }
        return $html;
    }
}
