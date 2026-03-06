<!-- Resultado da Consulta de Manifestação -->
<?php $m = $manifestacao; ?>

<nav class="navbar">
    <div class="container">
        <a href="/" class="navbar-brand">
            <span class="logo-icon">📢</span>
            VOX
        </a>
        <div class="navbar-actions">
            <a href="/consulta" class="btn btn-sm btn-secondary">← Nova Consulta</a>
        </div>
    </div>
</nav>

<main class="main-content">
    <div class="container" style="max-width: 800px;">
        <h1 class="text-center mb-4">📋 Acompanhamento</h1>
        <p class="text-center text-muted mb-8">
            Registro: <code style="font-size: 1.1rem;"><?= htmlspecialchars($m->registro) ?></code>
        </p>

        <!-- Status -->
        <div class="card mb-4">
            <div class="card-header">
                <h3>Status da Manifestação</h3>
                <span
                    class="badge <?= $m->codigoStatus === 2 ? 'badge-info' : ($m->codigoStatus === 1 ? 'badge-warning' : 'badge-success') ?>">
                    <?= htmlspecialchars($m->nomeStatus) ?>
                </span>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th style="width:130px;">Assunto</th>
                        <td>
                            <?= htmlspecialchars($m->assunto) ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Tipo</th>
                        <td>
                            <?= htmlspecialchars($m->nomeTipo) ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Data</th>
                        <td>
                            <?= $m->dataCriacao ? date('d/m/Y', strtotime($m->dataCriacao)) : '' ?>
                        </td>
                    </tr>
                    <?php if ($m->departamentos): ?>
                        <tr>
                            <th>Departamentos</th>
                            <td>
                                <?= $m->departamentos ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>

        <!-- Legenda de cores dos departamentos -->
        <?php if ($m->departamentos): ?>
            <div class="card mb-4">
                <div class="card-body" style="display: flex; gap: 1.5rem; justify-content: center; font-size: 0.875rem;">
                    <span><span class="text-danger">●</span> Pendente há mais de 5 dias</span>
                    <span><span class="text-warning">●</span> Pendente há menos de 5 dias</span>
                    <span><span class="text-success">●</span> Respondido</span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Resposta Final -->
        <?php if (!empty($m->respostaFinal)): ?>
            <div class="card mb-4" style="border-left: 4px solid var(--color-success);">
                <div class="card-header">
                    <h3>✅ Resposta Final</h3>
                </div>
                <div class="card-body">
                    <p style="white-space: pre-wrap; line-height: 1.8;">
                        <?= htmlspecialchars($m->respostaFinal) ?>
                    </p>
                    <?php if ($m->dataFinalizacao): ?>
                        <small class="text-muted mt-4">Respondido em:
                            <?= date('d/m/Y', strtotime($m->dataFinalizacao)) ?>
                        </small>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Feedback -->
            <?php if (empty($m->feedback)): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>💬 Dar Feedback</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">Sua opinião é importante! Avalie a resposta que recebeu.</p>
                        <form method="post" action="/feedback">
                            <input type="hidden" name="registro" value="<?= htmlspecialchars($m->registro) ?>">
                            <div class="form-group">
                                <textarea name="feedback" class="form-control" rows="4" required
                                    placeholder="O que achou da resposta? Ficou satisfeito(a)?"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar Feedback</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>💬 Seu Feedback</h3>
                    </div>
                    <div class="card-body">
                        <p style="white-space: pre-wrap;">
                            <?= htmlspecialchars($m->feedback) ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</main>