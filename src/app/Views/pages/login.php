<div class="login-container" style="max-width: 400px; margin: 6rem auto; animation: fadeInUp 0.5s ease both;">
    <div class="card" style="padding: 0;">
        <div style="background: var(--vox-green); padding: 3rem 2rem; text-align: center; color: white;">
            <img src="/assets/images/original_logo.png" alt="Logo"
                style="height: 60px; margin-bottom: 1rem; filter: brightness(0) invert(1);">
            <h2 style="font-weight: 800; letter-spacing: -0.01em;">ACESSO RESTRITO</h2>
            <p style="opacity: 0.8; font-size: 0.9rem;">Área Administrativa do Sistema VOX</p>
        </div>

        <div style="padding: 2.5rem 2rem;">
            <?php if ($flash = \Vox\Core\Session::getFlash('error')): ?>
                <div
                    style="background: #fee2e2; color: #991b1b; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.875rem;">
                    ❌ <?= htmlspecialchars($flash) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="/login">
                <div style="margin-bottom: 1.25rem;">
                    <label
                        style="display: block; font-weight: 700; font-size: 0.8rem; color: var(--slate-600); text-transform: uppercase; margin-bottom: 0.5rem;">Identificador</label>
                    <input type="text" name="txtLogin" class="form-control" placeholder="Seu usuário" required
                        autofocus>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label
                        style="display: block; font-weight: 700; font-size: 0.8rem; color: var(--slate-600); text-transform: uppercase; margin-bottom: 0.5rem;">Senha</label>
                    <input type="password" name="txtSenha" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary"
                    style="width: 100%; padding: 1rem; font-size: 1.1rem; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(103, 186, 44, 0.2);">
                    Entrar no Sistema
                </button>
            </form>
        </div>
    </div>

    <div style="text-align: center; margin-top: 2rem;">
        <a href="/" style="color: var(--slate-600); text-decoration: none; font-size: 0.9rem; font-weight: 600;">←
            Voltar para a Ouvidoria Pública</a>
    </div>
</div>