<!-- Confirmação de Manifestação Enviada -->
<nav class="navbar">
    <div class="container">
        <a href="/" class="navbar-brand">
            <span class="logo-icon">📢</span>
            VOX
        </a>
    </div>
</nav>

<main class="main-content">
    <div class="container" style="max-width: 600px;">
        <div class="card" style="text-align: center; padding: 3rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">✅</div>
            <h1 style="color: var(--color-success);">Manifestação Enviada!</h1>
            <p class="text-muted mt-4">Sua manifestação foi registrada com sucesso. Guarde o código abaixo para
                acompanhar o andamento.</p>

            <div
                style="background: var(--bg-secondary); border-radius: var(--radius-xl); padding: 2rem; margin: 2rem 0;">
                <p class="text-muted" style="font-size: 0.875rem;">Seu código de acompanhamento:</p>
                <h2
                    style="font-size: 2rem; color: var(--accent); letter-spacing: 0.1em; font-family: var(--font-mono);">
                    <?= htmlspecialchars($registro) ?>
                </h2>
            </div>

            <?php if (!empty($email)): ?>
                <p class="text-muted" style="font-size: 0.875rem;">
                    Uma cópia foi enviada para: <strong>
                        <?= htmlspecialchars($email) ?>
                    </strong>
                </p>
            <?php endif; ?>

            <div class="flex gap-4 justify-center mt-8" style="justify-content: center;">
                <a href="/consulta" class="btn btn-primary">🔍 Consultar Andamento</a>
                <a href="/manifestacao" class="btn btn-secondary">✍️ Nova Manifestação</a>
            </div>
        </div>
    </div>
</main>