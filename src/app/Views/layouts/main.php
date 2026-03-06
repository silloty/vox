<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#67ba2c">
    <title><?= htmlspecialchars($pageTitle ?? 'VOX - Gestão') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <div class="admin-layout">

        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="/admin" class="sidebar-brand">
                    <img src="/assets/images/original_logo.png" alt="VOX" class="sidebar-logo">
                    <span class="sidebar-brand-text">VOX GESTÃO</span>
                </a>
            </div>

            <nav class="sidebar-nav">
                <a href="/admin" class="<?= ($_SERVER['REQUEST_URI'] === '/admin') ? 'active' : '' ?>">
                    📊 Resumo Geral
                </a>
                <a href="/admin/abertas"
                    class="<?= str_contains($_SERVER['REQUEST_URI'], 'abertas') ? 'active' : '' ?>">
                    📩 Pendentes
                </a>
                <a href="/admin/andamento"
                    class="<?= str_contains($_SERVER['REQUEST_URI'], 'andamento') ? 'active' : '' ?>">
                    ⏳ Em Tratativa
                </a>
                <a href="/admin/fechadas"
                    class="<?= str_contains($_SERVER['REQUEST_URI'], 'fechadas') ? 'active' : '' ?>">
                    ✅ Concluídas
                </a>

                <div class="sidebar-divider"></div>

                <a href="/admin/departamentos"
                    class="<?= str_contains($_SERVER['REQUEST_URI'], 'departamento') ? 'active' : '' ?>">🏢 Setores</a>
                <a href="/admin/tipos" class="<?= str_contains($_SERVER['REQUEST_URI'], 'tipos') ? 'active' : '' ?>">📋
                    Categorias</a>
                <a href="/admin/clientelas"
                    class="<?= str_contains($_SERVER['REQUEST_URI'], 'clientelas') ? 'active' : '' ?>">👥 Segmentos</a>
                <a href="/admin/usuarios"
                    class="<?= str_contains($_SERVER['REQUEST_URI'], 'usuarios') ? 'active' : '' ?>">🛡️ Equipe</a>
            </nav>

            <div class="sidebar-footer">
                <p style="font-size: 0.7rem; color: var(--slate-400); text-align: center;">VOX Enterprise v2.5</p>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="main-area">

            <header class="top-bar">
                <div class="user-profile-block">
                    <span class="user-name-tag">
                        <?= htmlspecialchars(\Vox\Core\Session::getUserNome()) ?>
                    </span>
                    <a href="/logout" class="btn btn-sm btn-primary"
                        style="padding: 6px 14px; border-radius: 30px;">Sair</a>
                </div>
            </header>

            <div class="content-wrapper">
                <!-- Flash Messages Area -->
                <?php if ($flash = \Vox\Core\Session::getFlash('success')): ?>
                    <div class="alert alert-success">✅ <?= htmlspecialchars($flash) ?></div>
                <?php endif; ?>
                <?php if ($flash = \Vox\Core\Session::getFlash('error')): ?>
                    <div class="alert alert-error">❌ <?= htmlspecialchars($flash) ?></div>
                <?php endif; ?>

                <main class="main-content">
                    <?= $content ?>
                </main>
            </div>

            <footer class="footer"
                style="background: transparent; color: var(--slate-400); border-top: 1px solid var(--slate-100); margin-top: auto; padding: 2rem;">
                <div class="container">
                    <p>&copy; <?= date('Y') ?> VOX - Sistema de Ouvidoria | CGTI IFMG Campus Bambui</p>
                </div>
            </footer>
        </div>
    </div>

    <style>
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-weight: 600;
            animation: fadeInDown 0.3s ease;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script src="/assets/js/admin.js"></script>
</body>

</html>