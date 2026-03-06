<?php $m = $manifestacao; ?>

<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
    <div>
        <span class="badge"
            style="background: var(--vox-green-light); color: var(--vox-green-dark); margin-bottom: 0.5rem; display: inline-block;">
            Protocolo: <?= htmlspecialchars($m->registro) ?>
        </span>
        <h1 style="font-size: 2.25rem;"><?= htmlspecialchars($m->assunto) ?></h1>
    </div>
    <a href="javascript:history.back()" class="btn btn-secondary">← Voltar</a>
</div>

<div class="admin-grid">

    <!-- Lado Esquerdo: Conteúdo e Respostas -->
    <div class="main-column">

        <!-- Card de Origem -->
        <div class="card">
            <div class="card-header">📄 Detalhamento da Manifestação</div>
            <div class="card-body">
                <div
                    style="background: var(--slate-50); padding: 1.5rem; border-radius: 12px; border: 1px dashed var(--slate-300);">
                    <p style="white-space: pre-wrap; font-size: 1.1rem; line-height: 1.7; color: var(--slate-800);">
                        <?= htmlspecialchars($m->conteudo) ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Linha do Tempo (Workflow) -->
        <h3 style="margin: 2rem 0 1.5rem 0; display: flex; align-items: center; gap: 10px;">
            🕒 Fluxo de Resoluções
        </h3>

        <div class="timeline">
            <!-- Ponto Inicial -->
            <div class="timeline-item">
                <div class="card" style="margin-bottom: 0;">
                    <div class="card-body" style="padding: 1rem 1.5rem;">
                        <strong style="color: var(--vox-green);">Registro Inicial</strong><br>
                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($m->dataCriacao)) ?></small>
                    </div>
                </div>
            </div>

            <?php foreach ($andamentos as $a): ?>
                <div class="timeline-item <?= empty($a['resposta']) ? 'pending' : '' ?>">
                    <div class="card" style="margin-bottom: 0;">
                        <div class="card-header" style="background: white; border: none; padding-bottom: 0;">
                            <strong>🏢 Setor: <?= htmlspecialchars($a['departamento']) ?></strong>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($a['resposta'])): ?>
                                <div style="background: #f1f5f9; padding: 1rem; border-radius: 8px;">
                                    <p style="margin: 0; font-size: 0.95rem;"><?= htmlspecialchars($a['resposta']) ?></p>
                                    <div style="margin-top: 0.5rem; font-size: 0.8rem; color: var(--slate-500);">
                                        Respondido em: <?= date('d/m/Y H:i', strtotime($a['data_resposta'])) ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div
                                    style="border: 2px dashed var(--slate-200); padding: 1.5rem; text-align: center; border-radius: 12px;">
                                    <p class="text-muted" style="margin-bottom: 1rem;">Aguardando retorno deste setor...</p>

                                    <button class="btn btn-primary btn-sm" onclick="showResponseForm('<?= $a['registro'] ?>')">
                                        ✍️ Inserir Resposta do Setor
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if ($m->codigoStatus === 3): ?>
                <div class="timeline-item">
                    <div class="card" style="border: 2px solid var(--vox-green); background: #f0fdf4;">
                        <div class="card-header" style="background: var(--vox-green); color: white; border: none;">
                            ✅ MANIFESTAÇÃO FINALIZADA
                        </div>
                        <div class="card-body">
                            <strong>Conclusão da Ouvidoria:</strong>
                            <p style="margin-top: 0.5rem;"><?= htmlspecialchars($m->respostaFinal) ?></p>
                            <div style="margin-top: 1rem; font-size: 0.85rem; color: var(--vox-green-dark);">
                                Finalizada em: <?= date('d/m/Y', strtotime($m->dataFinalizacao)) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Lado Direito: Widget de Dados e Ações Rápidas -->
    <div class="quick-action-sidebar">

        <!-- Status Card -->
        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-body" style="text-align: center;">
                <label class="text-muted"
                    style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Status do Processo</label>
                <div style="font-size: 1.25rem; font-weight: 800; color: var(--vox-green-dark); margin: 0.5rem 0;">
                    <?= htmlspecialchars($m->nomeStatus) ?>
                </div>
                <?php if ($m->codigoStatus !== 3): ?>
                    <button class="btn btn-danger btn-block mt-4" onclick="showFinalizeForm()">
                        🚩 Finalizar Processo
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Person Card -->
        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-header">👤 Manifestante</div>
            <div class="card-body" style="padding: 1.25rem;">
                <?php if ($m->identificacao !== 'A'): ?>
                    <div style="font-weight: 700; color: var(--slate-900);"><?= htmlspecialchars($m->nome) ?></div>
                    <div style="font-size: 0.85rem; color: var(--slate-500); margin-bottom: 1rem;">
                        <?= htmlspecialchars($m->email) ?></div>

                    <div style="font-size: 0.85rem; border-top: 1px solid var(--slate-100); padding-top: 1rem;">
                        <strong>CPF:</strong> <?= htmlspecialchars($m->cpf) ?><br>
                        <strong>Fone:</strong> <?= htmlspecialchars($m->telefone) ?><br>
                        <strong>Tipo:</strong> <?= htmlspecialchars($m->nomeClientela) ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; color: var(--slate-400);">
                        <div style="font-size: 2rem;">🔒</div>
                        Manifestação Anônima
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Forward -->
        <?php if ($m->codigoStatus !== 3): ?>
            <div class="card">
                <div class="card-header">📤 Encaminhar Setor</div>
                <div class="card-body">
                    <form method="post" action="/admin/encaminhar">
                        <input type="hidden" name="manifestacao_id" value="<?= $m->codigo ?>">
                        <div style="margin-bottom: 1rem;">
                            <select name="departamento" class="form-control" style="font-size: 0.85rem;" required>
                                <option value="">Selecione o destino...</option>
                                <?= $comboDepartamentos ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Encaminhar Agora</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<!-- MODAIS OCULTOS -->
<div id="overlay">
    <!-- Modal Resposta -->
    <div id="modalResposta" class="modal" style="display:none;">
        <h3>✍️ Responder pelo Setor</h3>
        <p class="text-muted" style="font-size: 0.85rem; margin-bottom: 1.5rem;">Esta ação registra o retorno técnico
            que o departamento enviou à ouvidoria.</p>
        <form method="post" action="/admin/responder">
            <input type="hidden" name="registro_andamento" id="inputRegistroAndamento">
            <input type="hidden" name="manifestacao_id" value="<?= $m->codigo ?>">
            <textarea name="resposta" class="form-control" rows="6"
                placeholder="Copie aqui a resposta enviada pelo setor..." required></textarea>
            <div style="display: flex; gap: 10px; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">Salvar Resposta</button>
                <button type="button" class="btn btn-secondary" onclick="closeModals()">Cancelar</button>
            </div>
        </form>
    </div>

    <!-- Modal Finalizar -->
    <div id="modalFinalizar" class="modal" style="display:none;">
        <h3>🚩 Concluir Manifestação</h3>
        <p class="text-muted" style="font-size: 0.85rem; margin-bottom: 1.5rem;">O cidadão receberá esta resposta
            definitiva. Certifique-se de que todos os setores responderam.</p>
        <form method="post" action="/admin/finalizar">
            <input type="hidden" name="manifestacao_id" value="<?= $m->codigo ?>">
            <textarea name="resposta_final" class="form-control" rows="8"
                placeholder="Escreva a resposta conclusiva da ouvidoria para o cidadão..." required></textarea>
            <div style="display: flex; gap: 10px; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-danger" style="flex: 1;">Finalizar Agora</button>
                <button type="button" class="btn btn-secondary" onclick="closeModals()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showResponseForm(registro) {
        document.getElementById('inputRegistroAndamento').value = registro;
        document.getElementById('overlay').style.display = 'flex';
        document.getElementById('modalResposta').style.display = 'block';
        document.getElementById('modalFinalizar').style.display = 'none';
    }

    function showFinalizeForm() {
        document.getElementById('overlay').style.display = 'flex';
        document.getElementById('modalFinalizar').style.display = 'block';
        document.getElementById('modalResposta').style.display = 'none';
    }

    function closeModals() {
        document.getElementById('overlay').style.display = 'none';
    }
</script>