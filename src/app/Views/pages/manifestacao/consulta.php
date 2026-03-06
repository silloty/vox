<!-- Consulta de Andamento -->
<nav class="navbar">
    <div class="container">
        <a href="/" class="navbar-brand">
            <span class="logo-icon">📢</span>
            VOX
        </a>
        <div class="navbar-actions">
            <a href="/manifestacao" class="btn btn-sm btn-secondary">✍️ Nova Manifestação</a>
        </div>
    </div>
</nav>

<main class="main-content">
    <div class="container" style="max-width: 500px;">
        <h1 class="text-center mb-4">🔍 Consultar Manifestação</h1>
        <p class="text-muted text-center mb-8">Informe o código que você recebeu ao enviar sua manifestação.</p>

        <?php if ($flash = \Vox\Core\Session::getFlash('error')): ?>
            <div class="alert alert-error">❌
                <?= htmlspecialchars($flash) ?>
            </div>
        <?php endif; ?>
        <?php if ($flash = \Vox\Core\Session::getFlash('success')): ?>
            <div class="alert alert-success">✅
                <?= htmlspecialchars($flash) ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form method="post" action="/consulta">
                    <div class="form-group">
                        <label class="form-label">Código da Manifestação</label>
                        <input type="text" name="txtRegistro" class="form-control" placeholder="Ex: A1B2C3D4E5" required
                            autofocus
                            style="text-transform: uppercase; letter-spacing: 0.1em; text-align: center; font-size: 1.25rem;">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Consultar</button>
                </form>
            </div>
        </div>
    </div>
</main>