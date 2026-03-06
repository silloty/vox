<?php
/**
 * VOX - Sistema de Ouvidoria
 * Controller: Autenticação
 */

declare(strict_types=1);

namespace Vox\Controllers;

use Vox\Core\{Session, View};
use Vox\Models\Usuario;

class AuthController
{
    public function loginForm(): void
    {
        View::render('pages/login', ['pageTitle' => 'VOX - Login'], 'public');
    }

    public function login(): void
    {
        $login = trim($_POST['txtLogin'] ?? '');
        $senha = trim($_POST['txtSenha'] ?? '');

        // Debug Log
        error_log("[VOX DEBUG] Tentativa de login para: {$login}");

        if (empty($login) || empty($senha)) {
            error_log("[VOX DEBUG] Login falhou: campos vazios");
            Session::flash('error', 'Informe login e senha.');
            header('Location: /login');
            exit;
        }

        $usuario = new Usuario();
        if ($usuario->autentica($login, $senha)) {
            error_log("[VOX DEBUG] Credenciais válidas. Iniciando sessão para: {$login}");

            // Session::regenerate(); // Desativado temporariamente para debugar perda de sessão

            Session::setUser($usuario->codigo, $usuario->nome, $usuario->login);

            error_log("[VOX DEBUG] Sessão configurada: ID=" . session_id() . " UserID=" . Session::getUserId());

            header('Location: /admin');
            exit;
        }

        error_log("[VOX DEBUG] Login falhou: senha incorreta para {$login}");
        Session::flash('error', 'Login ou senha incorretos.');
        header('Location: /login');
        exit;
    }

    public function logout(): void
    {
        Session::destroy();
        header('Location: /');
        exit;
    }
}
