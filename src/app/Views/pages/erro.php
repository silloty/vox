<!-- Página de Erro (404, etc) -->
<nav class="navbar">
    <div class="container">
        <a href="/" class="navbar-brand">
            <span class="logo-icon">📢</span>
            VOX
        </a>
    </div>
</nav>

<main class="main-content">
    <div class="container" style="max-width: 600px; padding: 4rem 0; text-align: center;">
        <div class="card">
            <div class="card-body" style="padding: 4rem 2rem;">
                <div style="font-size: 5rem; margin-bottom: 1rem;">⚠️</div>
                <h1 style="color: var(--color-danger); letter-spacing: -0.025em;">
                    <?= htmlspecialchars($titulo ?? 'Ops! Ocorreu um erro.') ?>
                </h1>
                <p class="text-muted mt-4" style="font-size: 1.125rem;">
                    <?= htmlspecialchars($mensagem ?? 'Não foi possível processar sua solicitação neste momento.') ?>
                </p>
                <div class="mt-8">
                    <a href="<?= htmlspecialchars($voltar ?? '/') ?>" class="btn btn-primary btn-lg">
                        ← Voltar para a página anterior
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>