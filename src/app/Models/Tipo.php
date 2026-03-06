<?php
declare(strict_types=1);

namespace Vox\Models;

use Vox\Core\Database;

class Tipo
{
    public ?int $codigo = null;
    public string $nome = '';
    public bool $visivel = true;

    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function selecionaPorCodigo(int $codigo): bool
    {
        $row = $this->db->fetchOne(
            'SELECT tipo_id, nome, visivel FROM public.tipo WHERE tipo_id = :id',
            ['id' => $codigo]
        );
        if ($row) {
            $this->codigo = (int) $row['tipo_id'];
            $this->nome = $row['nome'];
            $this->visivel = (bool) $row['visivel'];
            return true;
        }
        return false;
    }

    public function excluir(int $codigo): void
    {
        $this->db->execute('DELETE FROM public.tipo WHERE tipo_id = :id', ['id' => $codigo]);
    }

    public function alterar(): void
    {
        $this->db->execute(
            'UPDATE tipo SET nome = :nome, visivel = :visivel WHERE tipo_id = :id',
            ['nome' => $this->nome, 'visivel' => $this->visivel ? 'true' : 'false', 'id' => $this->codigo]
        );
    }

    public function salvar(): void
    {
        $this->db->execute(
            'INSERT INTO public.tipo (nome, visivel) VALUES (:nome, :visivel)',
            ['nome' => $this->nome, 'visivel' => $this->visivel ? 'true' : 'false']
        );
    }

    public function listaTipoArray(): array
    {
        return $this->db->fetchAll('SELECT * FROM tipo ORDER BY nome');
    }

    /**
     * Lista combo com filtro de visibilidade (preserva lógica original)
     * @param int $apenasVisiveis 1 = apenas visíveis, 0 = todos
     */
    public function listaCombo(int $apenasVisiveis = 1): string
    {
        $sql = 'SELECT * FROM tipo';
        $params = [];
        if ($apenasVisiveis === 1) {
            $sql .= ' WHERE visivel = true';
        }
        $sql .= ' ORDER BY nome';

        $items = $this->db->fetchAll($sql, $params);
        $html = '';
        foreach ($items as $item) {
            $html .= '<option value="' . $item['tipo_id'] . '">' . htmlspecialchars($item['nome']) . '</option>';
        }
        return $html;
    }

    public function totalPorTipo(string $dataInicial, string $dataFinal): array
    {
        return $this->db->fetchAll(
            "SELECT t.nome, COUNT(DISTINCT m.manifestacao_id) as total
             FROM tipo t
             LEFT JOIN manifestacao m ON m.ref_tipo = t.tipo_id
                AND m.data_criacao >= :di AND m.data_criacao <= :df AND m.ref_status <> 2
             GROUP BY t.nome ORDER BY t.nome",
            ['di' => $dataInicial, 'df' => $dataFinal]
        );
    }
}
