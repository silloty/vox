<!-- Formulário de Manifestação (Público) -->
<nav class="navbar">
    <div class="container">
        <a href="/" class="navbar-brand">
            <span class="logo-icon">📢</span>
            VOX
        </a>
        <div class="navbar-actions">
            <a href="/consulta" class="btn btn-sm btn-secondary">🔍 Consultar Andamento</a>
        </div>
    </div>
</nav>

<main class="main-content">
    <div class="container">
        <div class="manifesto-wrapper">
            <h1 style="text-align: center; margin-bottom: 0.5rem;">✍️ Faça sua Manifestação</h1>
            <p class="text-muted text-center mb-8">Preencha o formulário abaixo. Sua voz é importante para nós.</p>

            <?php if ($flash = \Vox\Core\Session::getFlash('error')): ?>
                <div class="alert alert-error">❌
                    <?= htmlspecialchars($flash) ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="post" action="/manifestacao/enviar" id="frmManifestacao">

                        <!-- Dados básicos -->
                        <div class="form-group">
                            <label class="form-label">Eu sou *</label>
                            <select name="dpdClientela" class="form-control" required>
                                <option value="">-- Selecione --</option>
                                <?= $comboClientela ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Gostaria de fazer um(a) *</label>
                            <select name="dpdTipo" class="form-control" required>
                                <option value="">-- Selecione --</option>
                                <?= $comboTipo ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Meu email é</label>
                            <input type="email" name="txtEmail" class="form-control" placeholder="seuemail@exemplo.com">
                            <span class="form-hint">Importante para receber o código de acompanhamento.</span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Forma de Identificação *</label>
                            <select name="dpdIdentificacao" class="form-control" id="dpdIdentificacao" required
                                onchange="toggleDadosPessoais()">
                                <option value="">-- Selecione --</option>
                                <option value="I">Quero me identificar (Identificado)</option>
                                <option value="S">Quero ser identificado apenas pelo ouvidor(a) (Sigiloso)</option>
                                <option value="A">Não quero me identificar (Anônimo)</option>
                            </select>
                            <span class="form-hint">
                                <strong>Identificado:</strong> o departamento terá acesso ao seu nome.
                                <strong>Sigiloso:</strong> apenas o ouvidor(a).
                                <strong>Anônimo:</strong> ninguém terá acesso.
                            </span>
                        </div>

                        <!-- Dados Pessoais (condicional) -->
                        <div id="dadosPessoais" style="display: none;">
                            <hr style="border: none; border-top: 1px solid var(--border-color); margin: 1.5rem 0;">
                            <h4 class="mb-4">Dados Pessoais</h4>

                            <div class="grid-2 gap-4">
                                <div class="form-group">
                                    <label class="form-label">Nome</label>
                                    <input type="text" name="txtNome" class="form-control" maxlength="200">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">CPF</label>
                                    <input type="text" name="txtCPF" class="form-control" maxlength="14"
                                        placeholder="Somente números">
                                </div>
                            </div>

                            <div class="grid-2 gap-4">
                                <div class="form-group">
                                    <label class="form-label">Telefone</label>
                                    <input type="text" name="txtTelefone" class="form-control" maxlength="15">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Endereço</label>
                                    <input type="text" name="txtEndereco" class="form-control">
                                </div>
                            </div>
                        </div>

                        <hr style="border: none; border-top: 1px solid var(--border-color); margin: 1.5rem 0;">

                        <!-- Manifestação -->
                        <div class="form-group">
                            <label class="form-label">Assunto *</label>
                            <input type="text" name="txtAssunto" class="form-control" required maxlength="300"
                                placeholder="Resuma o assunto da sua manifestação">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Manifestação *</label>
                            <textarea name="txtManifestacao" class="form-control" rows="6" required
                                maxlength="<?= $maxChars ?>" id="txtManifestacao"
                                placeholder="Descreva sua manifestação com o máximo de detalhes..."
                                oninput="updateCounter()"></textarea>
                            <span class="form-hint">
                                <span id="charCounter">
                                    <?= $maxChars ?>
                                </span> caracteres restantes
                            </span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            📤 Enviar Manifestação
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function toggleDadosPessoais() {
        const sel = document.getElementById('dpdIdentificacao').value;
        const div = document.getElementById('dadosPessoais');
        div.style.display = (sel === 'I' || sel === 'S') ? 'block' : 'none';
    }

    function updateCounter() {
        const textarea = document.getElementById('txtManifestacao');
        const counter = document.getElementById('charCounter');
        const max = <?= $maxChars ?>;
        counter.textContent = max - textarea.value.length;
    }
</script>