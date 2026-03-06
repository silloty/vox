<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#67ba2c">
    <title><?= htmlspecialchars($pageTitle ?? 'VOX - Ouvidoria') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <div class="page-wrapper">

        <!-- Identidade Visual Clássica nas Páginas Públicas -->
        <header class="vintage-top-bar">
            <div class="vintage-top-bar-inner"></div>
        </header>

        <nav class="navbar">
            <div class="container">
                <a href="/" class="navbar-brand">
                    <span>OUVIDORIA DIGITAL</span>
                </a>
                <ul class="nav-links">
                    <li><a href="/" class="active">Início</a></li>
                    <li><a href="/manifestacao">Nova Manifestação</a></li>
                    <li><a href="/consulta">Acompanhar</a></li>
                    <li><a href="/login">Portal Administrativo</a></li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <main class="main-content">
                <?= $content ?>
            </main>
        </div>

        <footer class="footer">
            <div class="container">
                <img src="/assets/images/original_logo.png" alt="Logo" class="footer-logo">
                <p>&copy; <?= date('Y') ?> VOX - Sistema de Ouvidoria</p>
                <p style="font-size: 0.75rem; opacity: 0.6; margin-top: 0.5rem;">
                    CGTI IFMG Campus Bambuí
                </p>
            </div>
        </footer>
    </div>
</body>

</html>