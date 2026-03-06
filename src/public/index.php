<?php
/**
 * VOX - Sistema de Ouvidoria
 * Front Controller
 */

declare(strict_types=1);

// Autoloader PSR-4 simples
spl_autoload_register(function (string $class) {
    $prefix = 'Vox\\';
    $baseDir = __DIR__ . '/../app/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use Vox\Core\{Router, Session, View};
use Vox\Controllers\{AuthController, AdminController, ManifestacaoController};

// Iniciar sessão
Session::start();

// Configurar router
$router = new Router();

// --- Rotas Públicas ---
$router->get('/', function () {
    View::render('pages/home', ['pageTitle' => 'VOX - Sistema de Ouvidoria'], 'public');
});

$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

// Manifestação (público)
$router->get('/manifestacao', [ManifestacaoController::class, 'formulario']);
$router->post('/manifestacao/enviar', [ManifestacaoController::class, 'enviar']);
$router->get('/consulta', [ManifestacaoController::class, 'consultaForm']);
$router->post('/consulta', [ManifestacaoController::class, 'consultar']);
$router->post('/feedback', [ManifestacaoController::class, 'feedback']);

// --- Rotas Administrativas ---
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->get('/admin/abertas', [AdminController::class, 'abertas']);
$router->get('/admin/andamento', [AdminController::class, 'andamento']);
$router->get('/admin/fechadas', [AdminController::class, 'fechadas']);
$router->get('/admin/detalhes', [AdminController::class, 'detalhes']);
$router->post('/admin/encaminhar', [AdminController::class, 'encaminhar']);
$router->post('/admin/responder', [AdminController::class, 'responderAndamento']);
$router->post('/admin/finalizar', [AdminController::class, 'finalizarManifestacao']);

// CRUD
$router->get('/admin/departamentos', [AdminController::class, 'departamentos']);
$router->post('/admin/departamentos/salvar', [AdminController::class, 'salvarDepartamento']);
$router->post('/admin/departamentos/excluir', [AdminController::class, 'excluirDepartamento']);

$router->get('/admin/tipos', [AdminController::class, 'tipos']);
$router->post('/admin/tipos/salvar', [AdminController::class, 'salvarTipo']);

$router->get('/admin/clientelas', [AdminController::class, 'clientelas']);
$router->post('/admin/clientelas/salvar', [AdminController::class, 'salvarClientela']);

$router->get('/admin/statuses', [AdminController::class, 'statuses']);

$router->get('/admin/usuarios', [AdminController::class, 'usuarios']);
$router->post('/admin/usuarios/salvar', [AdminController::class, 'salvarUsuario']);

// Dispatch
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
