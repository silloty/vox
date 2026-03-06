<?php
/**
 * VOX - Sistema de Ouvidoria
 * Model: Clientela
 */

declare(strict_types=1);

namespace Vox\Models;

use Vox\Core\Database;

class Clientela
{
    public ?int $codigo = null;
    public string $nome = '';

    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function selecionaPorCodigo(int $codigo): bool
    {
        $row = $this->db->fetchOne(
            'SELECT clientela_id, nome FROM public.clientela WHERE clientela_id = :id',
            ['id' => $codigo]
        );
        if ($row) {
            $this->codigo = (int) $row['clientela_id'];
            $this->nome = $row['nome'];
            return true;
        }
        return false;
    }

    public function excluir(int $codigo): void
    {
        $this->db->execute('DELETE FROM public.clientela WHERE clientela_id = :id', ['id' => $codigo]);
    }

    public function alterar(): void
    {
        $this->db->execute(
            'UPDATE public.clientela SET nome = :nome WHERE clientela_id = :id',
            ['nome' => $this->nome, 'id' => $this->codigo]
        );
    }

    public function salvar(): void
    {
        $this->db->execute('INSERT INTO public.clientela (nome) VALUES (:nome)', ['nome' => $this->nome]);
    }

    public function listaClientelaArray(): array
    {
        return $this->db->fetchAll('SELECT * FROM public.clientela ORDER BY nome');
    }

    public function listaCombo(): string
    {
        $items = $this->listaClientelaArray();
        $html = '';
        foreach ($items as $item) {
            $html .= '<option value="' . $item['clientela_id'] . '">' . htmlspecialchars($item['nome']) . '</option>';
        }
        return $html;
    }

    public function totalPorClientela(string $dataInicial, string $dataFinal): array
    {
        return $this->db->fetchAll(
            "SELECT c.nome, COUNT(DISTINCT m.manifestacao_id) as total
             FROM clientela c
             LEFT JOIN manifestacao m ON m.ref_clientela = c.clientela_id
                AND m.data_criacao >= :di AND m.data_criacao <= :df AND m.ref_status <> 2
             GROUP BY c.nome ORDER BY c.nome",
            ['di' => $dataInicial, 'df' => $dataFinal]
        );
    }
}
