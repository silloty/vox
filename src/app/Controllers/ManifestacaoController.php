<?php
/**
 * VOX - Sistema de Ouvidoria
 * Controller: Manifestação (público - cidadão)
 */

declare(strict_types=1);

namespace Vox\Controllers;

use Vox\Core\{Session, View};
use Vox\Models\{Manifestacao, Clientela, Tipo};
use Vox\Config\AppConfig;

class ManifestacaoController
{
    /**
     * Formulário público de manifestação (modo_manifestando)
     */
    public function formulario(): void
    {
        $clientela = new Clientela();
        $tipo = new Tipo();
        $config = AppConfig::getInstance();

        View::render('pages/manifestacao/formulario', [
            'pageTitle' => 'VOX - Faça sua Manifestação',
            'comboClientela' => $clientela->listaCombo(),
            'comboTipo' => $tipo->listaCombo(1),
            'maxChars' => $config->maxCharsManifestacao,
        ], 'public');
    }

    /**
     * Processa o envio de uma manifestação
     */
    public function enviar(): void
    {
        $m = new Manifestacao();
        $m->codigoClientela = (int) ($_POST['dpdClientela'] ?? 0);
        $m->codigoTipo = (int) ($_POST['dpdTipo'] ?? 0);
        $m->email = trim($_POST['txtEmail'] ?? '');
        $m->identificacao = trim($_POST['dpdIdentificacao'] ?? 'A');
        $m->nome = trim($_POST['txtNome'] ?? '');
        $m->cpf = trim($_POST['txtCPF'] ?? '');
        $m->telefone = trim($_POST['txtTelefone'] ?? '');
        $m->endereco = trim($_POST['txtEndereco'] ?? '');
        $m->assunto = trim($_POST['txtAssunto'] ?? '');
        $m->conteudo = trim($_POST['txtManifestacao'] ?? '');
        $m->anonimato = ($m->identificacao === 'A');

        // Validações básicas
        if (empty($m->conteudo) || $m->codigoClientela <= 0 || $m->codigoTipo <= 0) {
            Session::flash('error', 'Preencha todos os campos obrigatórios.');
            header('Location: /manifestacao');
            exit;
        }

        if (empty($m->identificacao)) {
            Session::flash('error', 'Selecione o tipo de identificação.');
            header('Location: /manifestacao');
            exit;
        }

        $registro = $m->enviar();

        // Salva dados de sessão para eventual reutilização
        Session::set('vox_ultimo_registro', $registro);

        View::render('pages/manifestacao/confirmacao', [
            'pageTitle' => 'Manifestação Enviada',
            'registro' => $registro,
            'email' => $m->email,
        ], 'public');
    }

    /**
     * Formulário de consulta de andamento
     */
    public function consultaForm(): void
    {
        View::render('pages/manifestacao/consulta', [
            'pageTitle' => 'Consultar Manifestação',
        ], 'public');
    }

    /**
     * Resultado da consulta
     */
    public function consultar(): void
    {
        $registro = trim($_POST['txtRegistro'] ?? $_GET['registro'] ?? '');

        if (empty($registro)) {
            Session::flash('error', 'Informe o código da manifestação.');
            header('Location: /consulta');
            exit;
        }

        $m = new Manifestacao();
        $m->registro = $registro;

        if (!$m->consultar()) {
            Session::flash('error', 'Manifestação não encontrada. Verifique o código informado.');
            header('Location: /consulta');
            exit;
        }

        View::render('pages/manifestacao/resultado', [
            'pageTitle' => 'Acompanhamento da Manifestação',
            'manifestacao' => $m,
        ], 'public');
    }

    /**
     * Enviar feedback do manifestante
     */
    public function feedback(): void
    {
        $registro = trim($_POST['registro'] ?? '');
        $feedbackTexto = trim($_POST['feedback'] ?? '');

        $m = new Manifestacao();
        $m->registro = $registro;
        $m->feedback = $feedbackTexto;
        $m->enviarFeedback();

        Session::flash('success', 'Feedback enviado com sucesso! Obrigado.');
        header("Location: /consulta?registro={$registro}");
        exit;
    }
}
