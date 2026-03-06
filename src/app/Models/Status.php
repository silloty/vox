<?php
declare(strict_types=1);

namespace Vox\Models;

use Vox\Core\Database;

class Status
{
    public ?int $codigo = null;
    public string $nome = '';
    public string $descricao = '';

    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function selecionaPorCodigo(int $codigo): bool
    {
        $row = $this->db->fetchOne(
            'SELECT status_id, nome, descricao FROM public.status WHERE status_id = :id',
            ['id' => $codigo]
        );
        if ($row) {
            $this->codigo = (int) $row['status_id'];
            $this->nome = $row['nome'];
            $this->descricao = $row['descricao'] ?? '';
            return true;
        }
        return false;
    }

    public function excluir(int $codigo): void
    {
        $this->db->execute('DELETE FROM public.status WHERE status_id = :id', ['id' => $codigo]);
    }

    public function alterar(): void
    {
        $this->db->execute(
            'UPDATE public.status SET nome = :nome, descricao = :descricao WHERE status_id = :id',
            ['nome' => $this->nome, 'descricao' => $this->descricao, 'id' => $this->codigo]
        );
    }

    public function salvar(): void
    {
        $this->db->execute(
            'INSERT INTO public.status (nome, descricao) VALUES (:nome, :descricao)',
            ['nome' => $this->nome, 'descricao' => $this->descricao]
        );
    }

    public function listaStatusArray(): array
    {
        return $this->db->fetchAll('SELECT * FROM public.status ORDER BY nome');
    }

    public function listaCombo(): string
    {
        $items = $this->listaStatusArray();
        $html = '';
        foreach ($items as $item) {
            $html .= '<option value="' . $item['status_id'] . '">' . htmlspecialchars($item['nome']) . '</option>';
        }
        return $html;
    }

    public function totalPorStatus(string $dataInicial, string $dataFinal): array
    {
        return $this->db->fetchAll(
            "SELECT s.nome, COUNT(DISTINCT m.manifestacao_id) as total
             FROM status s
             LEFT JOIN manifestacao m ON m.ref_status = s.status_id
                AND m.data_criacao >= :di AND m.data_criacao <= :df
             GROUP BY s.nome ORDER BY s.nome",
            ['di' => $dataInicial, 'df' => $dataFinal]
        );
    }
}
