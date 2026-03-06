<?php
/**
 * VOX - Sistema de Ouvidoria
 * Model: Manifestação (Core do Sistema)
 * 
 * Preserva 100% da lógica de negócio do manifestacao.cls.php original
 * Modernizado com PHP 8.2, PDO prepared statements
 */

declare(strict_types=1);

namespace Vox\Models;

use Vox\Core\Database;
use Vox\Config\AppConfig;

class Manifestacao
{
    // Dados da manifestação
    public ?int $codigo = null;
    public string $nome = '';
    public string $cpf = '';
    public string $endereco = '';
    public string $telefone = '';
    public string $email = '';
    public ?string $dataCriacao = null;
    public ?string $dataFinalizacao = null;
    public string $registro = '';
    public string $assunto = '';
    public string $conteudo = '';
    public string $identificacao = 'A'; // I = Identificado, S = Sigiloso, A = Anônimo
    public ?string $respostaFinal = null;
    public bool $anonimato = false;
    public ?string $feedback = null;
    public bool $visualizado = false;

    // Dados relacionados
    public ?int $codigoClientela = null;
    public string $nomeClientela = '';
    public ?int $codigoStatus = null;
    public string $nomeStatus = '';
    public ?int $codigoTipo = null;
    public string $nomeTipo = '';
    public string $departamentos = '';
    public string $departamentosSimples = '';

    // Dados de andamento
    public ?string $dataEnvio = null;
    public ?string $dataResposta = null;
    public ?string $horaEnvio = null;
    public ?string $horaResposta = null;
    public ?string $resposta = null;

    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Gera um registro único para a manifestação
     */
    private function geraRegistro(): string
    {
        return strtoupper(substr(md5(uniqid((string) mt_rand(), true)), 0, 10));
    }

    /**
     * Marca manifestação como vista
     */
    public function marcarComoVisto(): void
    {
        $this->db->execute(
            'UPDATE public.manifestacao SET visualizado = TRUE WHERE manifestacao_id = :id',
            ['id' => $this->codigo]
        );
    }

    /**
     * Desmarca manifestação como vista
     */
    public function desmarcarComoVisto(): void
    {
        $this->db->execute(
            'UPDATE public.manifestacao SET visualizado = FALSE WHERE manifestacao_id = :id',
            ['id' => $this->codigo]
        );
    }

    /**
     * Enviar nova manifestação (preserva lógica original do Enviar())
     */
    public function enviar(): string
    {
        $this->registro = $this->geraRegistro();

        $this->db->execute(
            "INSERT INTO public.manifestacao 
                (forma_identificacao, nome, email, cpf, telefone, ref_tipo, assunto, conteudo, 
                 ref_clientela, registro, anonimato, data_criacao, ref_status, endereco, data_hora, visualizado)
             VALUES 
                (:identificacao, :nome, :email, :cpf, :telefone, :tipo, :assunto, :conteudo,
                 :clientela, :registro, :anonimato, CURRENT_DATE, 2, :endereco, CURRENT_TIMESTAMP, FALSE)",
            [
                'identificacao' => $this->identificacao,
                'nome' => $this->nome,
                'email' => $this->email,
                'cpf' => $this->cpf,
                'telefone' => $this->telefone,
                'tipo' => $this->codigoTipo,
                'assunto' => $this->assunto,
                'conteudo' => $this->conteudo,
                'clientela' => $this->codigoClientela,
                'registro' => $this->registro,
                'anonimato' => $this->anonimato ? 'true' : 'false',
                'endereco' => $this->endereco,
            ]
        );

        return $this->registro;
    }

    /**
     * Deleta uma manifestação
     */
    public function deletaManifestacao(string $registro): void
    {
        $this->db->execute(
            'DELETE FROM manifestacao WHERE registro = :registro',
            ['registro' => $registro]
        );
    }

    /**
     * Consulta manifestação pelo registro (usado pelo cidadão)
     * Preserva a lógica original do Consultar()
     */
    public function consultar(): bool
    {
        $row = $this->db->fetchOne(
            'SELECT * FROM vw_manifestacao WHERE registro = :registro',
            ['registro' => $this->registro]
        );

        if (!$row) {
            return false;
        }

        $this->preencherDaRow($row);

        // Captura departamentos por quais a manifestação passou
        $deptos = $this->db->fetchAll(
            "SELECT d.nome, a.resposta, a.data_envio
             FROM departamento d, andamento a
             WHERE a.ref_manifestacao = (SELECT manifestacao_id FROM manifestacao WHERE registro = :registro)
             AND d.departamento_id = a.ref_departamento",
            ['registro' => $this->registro]
        );

        $this->departamentos = '';
        foreach ($deptos as $d) {
            $diasEnvio = $this->calcDiasDesde($d['data_envio']);
            $nomeDepto = htmlspecialchars($d['nome']);

            if (empty(trim($d['resposta'] ?? '')) && $diasEnvio > 5) {
                $depto = '<span class="text-danger">' . $nomeDepto . '</span>';
            } elseif (empty(trim($d['resposta'] ?? '')) && $diasEnvio <= 5) {
                $depto = '<span class="text-warning">' . $nomeDepto . '</span>';
            } else {
                $depto = '<span class="text-success">' . $nomeDepto . '</span>';
            }

            $this->departamentos .= $depto . ', ';
        }
        $this->departamentos = rtrim($this->departamentos, ', ');

        return true;
    }

    /**
     * Consulta por código (usado pelo admin)
     */
    public function consultarPorCodigo(): bool
    {
        $row = $this->db->fetchOne(
            'SELECT * FROM vw_manifestacao WHERE manifestacao_id = :id',
            ['id' => $this->codigo]
        );

        if (!$row) {
            return false;
        }

        $this->preencherDaRow($row);

        // Captura departamentos com dados completos de andamento
        $deptos = $this->db->fetchAll(
            "SELECT d.nome, d.departamento_id, a.resposta, a.data_envio, a.hora_envio,
                    a.data_resposta, a.hora_resposta, a.registro, a.andamento_id
             FROM departamento d, andamento a
             WHERE a.ref_manifestacao = :id AND d.departamento_id = a.ref_departamento",
            ['id' => $this->codigo]
        );

        $this->departamentos = '';
        $this->departamentosSimples = '';

        foreach ($deptos as $d) {
            $diasEnvio = $this->calcDiasDesde($d['data_envio']);
            $nomeDepto = htmlspecialchars($d['nome']);

            if (empty(trim($d['resposta'] ?? '')) && $diasEnvio > 5) {
                $depto = '<span class="text-danger">' . $nomeDepto . '</span>';
            } elseif (empty(trim($d['resposta'] ?? '')) && $diasEnvio <= 5) {
                $depto = '<span class="text-warning">' . $nomeDepto . '</span>';
            } else {
                $depto = '<span class="text-success">' . $nomeDepto . '</span>';
            }

            $this->departamentos .= $depto . ', ';
            $this->departamentosSimples .= $nomeDepto . ', ';
        }
        $this->departamentos = rtrim($this->departamentos, ', ');
        $this->departamentosSimples = rtrim($this->departamentosSimples, ', ');

        return true;
    }

    /**
     * Lista manifestações abertas (ref_status = 2)
     */
    public function listaAbertasArray(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM vw_manifestacao WHERE codigo_status = 2 ORDER BY data_criacao DESC"
        );
    }

    /**
     * Lista manifestações em andamento (ref_status = 1)
     */
    public function listaAndamentoArray(): array
    {
        return $this->db->fetchAll(
            "SELECT v.*, string_agg(d.nome, ', ') as departamentos
             FROM vw_manifestacao v
             LEFT JOIN andamento a ON a.ref_manifestacao = v.manifestacao_id
             LEFT JOIN departamento d ON d.departamento_id = a.ref_departamento
             WHERE v.codigo_status = 1
             GROUP BY v.manifestacao_id, v.forma_identificacao, v.nome, v.email, v.cpf,
                      v.telefone, v.endereco, v.assunto, v.conteudo, v.registro, v.anonimato,
                      v.data_criacao, v.data_finalizacao, v.data_hora, v.resposta_final, v.feedback,
                      v.visualizado, v.codigo_clientela, v.nome_clientela, v.codigo_status,
                      v.nome_status, v.codigo_tipo, v.nome_tipo
             ORDER BY v.data_criacao DESC"
        );
    }

    /**
     * Lista manifestações fechadas (ref_status <> 1 AND <> 2)
     */
    public function listaFechadasArray(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM vw_manifestacao WHERE codigo_status NOT IN (1, 2) ORDER BY data_finalizacao DESC"
        );
    }

    /**
     * Alterar manifestação
     */
    public function alterar(): void
    {
        $this->db->execute(
            "UPDATE public.manifestacao SET 
                nome = :nome, email = :email, cpf = :cpf, telefone = :telefone,
                ref_tipo = :tipo, assunto = :assunto, conteudo = :conteudo,
                ref_clientela = :clientela, forma_identificacao = :identificacao, endereco = :endereco
             WHERE manifestacao_id = :id",
            [
                'nome' => $this->nome,
                'email' => $this->email,
                'cpf' => $this->cpf,
                'telefone' => $this->telefone,
                'tipo' => $this->codigoTipo,
                'assunto' => $this->assunto,
                'conteudo' => $this->conteudo,
                'clientela' => $this->codigoClientela,
                'identificacao' => $this->identificacao,
                'endereco' => $this->endereco,
                'id' => $this->codigo,
            ]
        );
    }

    /**
     * Alterar status da manifestação
     */
    public function alterarStatus(): void
    {
        $this->db->execute(
            'UPDATE public.manifestacao SET ref_status = :status WHERE manifestacao_id = :id',
            ['status' => $this->codigoStatus, 'id' => $this->codigo]
        );
    }

    /**
     * Encaminhar manifestação para departamento
     */
    public function encaminharDepto(int $codDepto): string
    {
        $regAndamento = $this->geraRegistro();

        $this->db->execute(
            "INSERT INTO andamento (ref_manifestacao, ref_departamento, data_envio, registro, hora_envio) 
             VALUES (:manifestacao, :departamento, CURRENT_DATE, :registro, CURRENT_TIME)",
            [
                'manifestacao' => $this->codigo,
                'departamento' => $codDepto,
                'registro' => $regAndamento,
            ]
        );

        // Altera status para "Em Andamento" (1)
        $this->codigoStatus = 1;
        $this->alterarStatus();

        return $regAndamento;
    }

    /**
     * Responder andamento (departamento responde)
     */
    public function responder(string $regAndamento): void
    {
        $this->db->execute(
            "UPDATE andamento SET resposta = :resposta, data_resposta = CURRENT_DATE, hora_resposta = CURRENT_TIME
             WHERE registro = :registro",
            ['resposta' => $this->resposta, 'registro' => $regAndamento]
        );
    }

    /**
     * Enviar feedback do manifestante
     */
    public function enviarFeedback(): void
    {
        $this->db->execute(
            'UPDATE manifestacao SET feedback = :feedback WHERE registro = :registro',
            ['feedback' => $this->feedback, 'registro' => $this->registro]
        );
    }

    /**
     * Finalizar manifestação
     */
    public function finalizar(): void
    {
        $this->db->execute(
            "UPDATE manifestacao SET 
                resposta_final = :resposta, ref_status = 3, data_finalizacao = CURRENT_DATE
             WHERE manifestacao_id = :id",
            ['resposta' => $this->respostaFinal, 'id' => $this->codigo]
        );
    }

    /**
     * Verifica se resposta final já existe
     */
    public function verificaRespostaFinal(): bool
    {
        $resposta = $this->db->fetchColumn(
            'SELECT resposta_final FROM manifestacao WHERE registro = :registro',
            ['registro' => $this->registro]
        );
        return !empty(trim($resposta ?: ''));
    }

    /**
     * Verifica se feedback já existe
     */
    public function verificaFeedback(): bool
    {
        $feedback = $this->db->fetchColumn(
            'SELECT feedback FROM manifestacao WHERE registro = :registro',
            ['registro' => $this->registro]
        );
        return !empty(trim($feedback ?: ''));
    }

    /**
     * Conta total de manifestações por status
     */
    public function pegaTotalManifestacao(int $status): int
    {
        if ($status === 1 || $status === 2) {
            $total = $this->db->fetchColumn(
                'SELECT COUNT(manifestacao_id) FROM manifestacao WHERE ref_status = :status',
                ['status' => $status]
            );
        } else {
            $total = $this->db->fetchColumn(
                'SELECT COUNT(manifestacao_id) FROM manifestacao WHERE ref_status <> 1 AND ref_status <> 2'
            );
        }
        return (int) $total;
    }

    /**
     * Pega respostas de departamentos para uma manifestação
     */
    public function pegaRespostasDepartamentos(int $codManifestacao): array
    {
        return $this->db->fetchAll(
            "SELECT d.nome as departamento, a.resposta, a.data_envio, a.hora_envio,
                    a.data_resposta, a.hora_resposta, a.registro, a.andamento_id
             FROM andamento a
             JOIN departamento d ON d.departamento_id = a.ref_departamento
             WHERE a.ref_manifestacao = :id
             ORDER BY a.data_envio",
            ['id' => $codManifestacao]
        );
    }

    /**
     * Total de manifestações por período
     */
    public function pegaTotalManifestacoesPeriodo(string $dataInicial, string $dataFinal): int
    {
        $total = $this->db->fetchColumn(
            "SELECT COUNT(manifestacao_id) FROM manifestacao 
             WHERE data_criacao >= :di AND data_criacao <= :df AND ref_status <> 2",
            ['di' => $dataInicial, 'df' => $dataFinal]
        );
        return (int) $total;
    }

    /**
     * Filtro por status (preserva lógica de ListaFiltroStatusArray)
     */
    public function listaFiltroStatusArray(string $valor, int $idStatus, string $tipoFiltro): array
    {
        $sql = "SELECT * FROM vw_manifestacao WHERE 1=1";
        $params = [];

        if (!empty($valor)) {
            $sql .= " AND (LOWER(nome) LIKE :valor OR LOWER(assunto) LIKE :valor OR registro LIKE :valor)";
            $params['valor'] = '%' . mb_strtolower($valor) . '%';
        }

        if ($tipoFiltro === 'abertas') {
            $sql .= " AND codigo_status = 2";
        } elseif ($tipoFiltro === 'andamento') {
            $sql .= " AND codigo_status = 1";
        } else {
            $sql .= " AND codigo_status NOT IN (1, 2)";
        }

        $sql .= " ORDER BY data_criacao DESC";

        return $this->db->fetchAll($sql, $params);
    }

    // --- Métodos auxiliares ---

    private function preencherDaRow(array $row): void
    {
        $this->codigo = (int) $row['manifestacao_id'];
        $this->nome = $row['nome'] ?? '';
        $this->cpf = $row['cpf'] ?? '';
        $this->endereco = $row['endereco'] ?? '';
        $this->telefone = $row['telefone'] ?? '';
        $this->email = $row['email'] ?? '';
        $this->dataCriacao = $row['data_criacao'] ?? null;
        $this->dataFinalizacao = $row['data_finalizacao'] ?? null;
        $this->registro = $row['registro'];
        $this->assunto = $row['assunto'] ?? '';
        $this->conteudo = $row['conteudo'] ?? '';
        $this->identificacao = $row['forma_identificacao'] ?? 'A';
        $this->respostaFinal = $row['resposta_final'] ?? null;
        $this->anonimato = (bool) ($row['anonimato'] ?? false);
        $this->feedback = $row['feedback'] ?? null;
        $this->visualizado = (bool) ($row['visualizado'] ?? false);
        $this->codigoClientela = isset($row['codigo_clientela']) ? (int) $row['codigo_clientela'] : null;
        $this->nomeClientela = $row['nome_clientela'] ?? '';
        $this->codigoStatus = isset($row['codigo_status']) ? (int) $row['codigo_status'] : null;
        $this->nomeStatus = $row['nome_status'] ?? '';
        $this->codigoTipo = isset($row['codigo_tipo']) ? (int) $row['codigo_tipo'] : null;
        $this->nomeTipo = $row['nome_tipo'] ?? '';
    }

    private function calcDiasDesde(?string $data): int
    {
        if (empty($data))
            return 0;
        try {
            $date = new \DateTime($data);
            $now = new \DateTime();
            return (int) $now->diff($date)->days;
        } catch (\Exception) {
            return 0;
        }
    }
}
