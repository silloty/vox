<?php
/**
 * VOX - Sistema de Ouvidoria
 * Controller: Admin (painel principal)
 */

declare(strict_types=1);

namespace Vox\Controllers;

use Vox\Core\{Session, View};
use Vox\Models\{Manifestacao, Departamento, Tipo, Clientela, Status, Usuario};

class AdminController
{
    public function __construct()
    {
        if (!Session::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
    }

    public function dashboard(): void
    {
        $manifestacao = new Manifestacao();

        View::render('pages/admin/dashboard', [
            'pageTitle' => 'VOX - Painel Administrativo',
            'totalAbertas' => $manifestacao->pegaTotalManifestacao(2),
            'totalAndamento' => $manifestacao->pegaTotalManifestacao(1),
            'totalFechadas' => $manifestacao->pegaTotalManifestacao(3),
            'nomeUsuario' => Session::getUserNome(),
        ]);
    }

    // --- MANIFESTAÇÕES ---

    public function abertas(): void
    {
        $m = new Manifestacao();
        View::render('pages/admin/manifestacoes_lista', [
            'pageTitle' => 'Manifestações Abertas',
            'manifestacoes' => $m->listaAbertasArray(),
            'tipo' => 'abertas',
        ]);
    }

    public function andamento(): void
    {
        $m = new Manifestacao();
        View::render('pages/admin/manifestacoes_lista', [
            'pageTitle' => 'Manifestações em Andamento',
            'manifestacoes' => $m->listaAndamentoArray(),
            'tipo' => 'andamento',
        ]);
    }

    public function fechadas(): void
    {
        $m = new Manifestacao();
        View::render('pages/admin/manifestacoes_lista', [
            'pageTitle' => 'Manifestações Fechadas',
            'manifestacoes' => $m->listaFechadasArray(),
            'tipo' => 'fechadas',
        ]);
    }

    public function detalhes(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: /admin');
            exit;
        }

        $m = new Manifestacao();
        $m->codigo = $id;

        if (!$m->consultarPorCodigo()) {
            Session::flash('error', 'Manifestação não encontrada.');
            header('Location: /admin');
            exit;
        }

        $andamentos = $m->pegaRespostasDepartamentos($id);
        $departamento = new Departamento();

        View::render('pages/admin/manifestacao_detalhes', [
            'pageTitle' => 'Detalhes da Manifestação',
            'manifestacao' => $m,
            'andamentos' => $andamentos,
            'comboDepartamentos' => $departamento->listaCombo(),
        ]);
    }

    public function encaminhar(): void
    {
        $id = (int) ($_POST['manifestacao_id'] ?? 0);
        $codDepto = (int) ($_POST['departamento'] ?? 0);

        if ($id <= 0 || $codDepto <= 0) {
            Session::flash('error', 'Dados inválidos.');
            header('Location: /admin');
            exit;
        }

        $m = new Manifestacao();
        $m->codigo = $id;
        $m->encaminharDepto($codDepto);

        Session::flash('success', 'Manifestação encaminhada com sucesso!');
        header("Location: /admin/detalhes?id={$id}");
        exit;
    }

    public function responderAndamento(): void
    {
        $regAndamento = trim($_POST['registro_andamento'] ?? '');
        $resposta = trim($_POST['resposta'] ?? '');
        $idManifestacao = (int) ($_POST['manifestacao_id'] ?? 0);

        $m = new Manifestacao();
        $m->resposta = $resposta;
        $m->responder($regAndamento);

        Session::flash('success', 'Resposta enviada com sucesso!');
        header("Location: /admin/detalhes?id={$idManifestacao}");
        exit;
    }

    public function finalizarManifestacao(): void
    {
        $id = (int) ($_POST['manifestacao_id'] ?? 0);
        $respostaFinal = trim($_POST['resposta_final'] ?? '');

        $m = new Manifestacao();
        $m->codigo = $id;
        $m->respostaFinal = $respostaFinal;
        $m->finalizar();

        Session::flash('success', 'Manifestação finalizada com sucesso!');
        header('Location: /admin/fechadas');
        exit;
    }

    // --- CRUD DEPARTAMENTOS ---

    public function departamentos(): void
    {
        $d = new Departamento();
        View::render('pages/cadastros/lista_generica', [
            'pageTitle' => 'Departamentos',
            'items' => $d->listaDepartamentoArray(),
            'tipo' => 'departamento',
            'campos' => ['departamento_id' => 'ID', 'nome' => 'Nome', 'email' => 'Email'],
        ]);
    }

    public function salvarDepartamento(): void
    {
        $d = new Departamento();
        $d->nome = trim($_POST['nome'] ?? '');
        $d->email = trim($_POST['email'] ?? '');
        $d->descricao = trim($_POST['descricao'] ?? '');

        $id = (int) ($_POST['id'] ?? 0);
        if ($id > 0) {
            $d->codigo = $id;
            $d->alterar();
            Session::flash('success', 'Departamento atualizado!');
        } else {
            $d->salvar();
            Session::flash('success', 'Departamento cadastrado!');
        }
        header('Location: /admin/departamentos');
        exit;
    }

    public function excluirDepartamento(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id > 0) {
            $d = new Departamento();
            $d->excluir($id);
            Session::flash('success', 'Departamento excluído!');
        }
        header('Location: /admin/departamentos');
        exit;
    }

    // --- CRUD TIPOS ---

    public function tipos(): void
    {
        $t = new Tipo();
        View::render('pages/cadastros/lista_generica', [
            'pageTitle' => 'Tipos de Manifestação',
            'items' => $t->listaTipoArray(),
            'tipo' => 'tipo',
            'campos' => ['tipo_id' => 'ID', 'nome' => 'Nome', 'visivel' => 'Visível'],
        ]);
    }

    public function salvarTipo(): void
    {
        $t = new Tipo();
        $t->nome = trim($_POST['nome'] ?? '');
        $t->visivel = isset($_POST['visivel']);

        $id = (int) ($_POST['id'] ?? 0);
        if ($id > 0) {
            $t->codigo = $id;
            $t->alterar();
        } else {
            $t->salvar();
        }
        Session::flash('success', 'Tipo salvo com sucesso!');
        header('Location: /admin/tipos');
        exit;
    }

    // --- CRUD CLIENTELA ---

    public function clientelas(): void
    {
        $c = new Clientela();
        View::render('pages/cadastros/lista_generica', [
            'pageTitle' => 'Clientela',
            'items' => $c->listaClientelaArray(),
            'tipo' => 'clientela',
            'campos' => ['clientela_id' => 'ID', 'nome' => 'Nome'],
        ]);
    }

    public function salvarClientela(): void
    {
        $c = new Clientela();
        $c->nome = trim($_POST['nome'] ?? '');

        $id = (int) ($_POST['id'] ?? 0);
        if ($id > 0) {
            $c->codigo = $id;
            $c->alterar();
        } else {
            $c->salvar();
        }
        Session::flash('success', 'Clientela salva!');
        header('Location: /admin/clientelas');
        exit;
    }

    // --- CRUD STATUS ---

    public function statuses(): void
    {
        $s = new Status();
        View::render('pages/cadastros/lista_generica', [
            'pageTitle' => 'Status',
            'items' => $s->listaStatusArray(),
            'tipo' => 'status',
            'campos' => ['status_id' => 'ID', 'nome' => 'Nome', 'descricao' => 'Descrição'],
        ]);
    }

    // --- CRUD USUÁRIOS ---

    public function usuarios(): void
    {
        $u = new Usuario();
        View::render('pages/cadastros/lista_generica', [
            'pageTitle' => 'Usuários',
            'items' => $u->listaUsuarioArray(),
            'tipo' => 'usuario',
            'campos' => ['usuario_id' => 'ID', 'nome' => 'Nome', 'login' => 'Login'],
        ]);
    }

    public function salvarUsuario(): void
    {
        $u = new Usuario();
        $u->nome = trim($_POST['nome'] ?? '');
        $u->login = trim($_POST['login'] ?? '');
        $u->senha = trim($_POST['senha'] ?? '');

        $id = (int) ($_POST['id'] ?? 0);
        if ($id > 0) {
            $u->codigo = $id;
            $u->alterar();
        } else {
            $u->salvar();
        }
        Session::flash('success', 'Usuário salvo!');
        header('Location: /admin/usuarios');
        exit;
    }
}
