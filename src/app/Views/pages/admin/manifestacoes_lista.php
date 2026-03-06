<?php
$titulos = [
    'abertas' => ['titulo' => 'Pendentes', 'color' => 'var(--color-info)', 'icon' => '📩'],
    'andamento' => ['titulo' => 'Em Tratativa', 'color' => 'var(--color-warning)', 'icon' => '⏳'],
    'fechadas' => ['titulo' => 'Concluídas', 'color' => 'var(--color-success)', 'icon' => '✅'],
];
$info = $titulos[$tipo] ?? $titulos['abertas'];
?>

<div
    style="display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 2.5rem; gap: 2rem; flex-wrap: wrap;">
    <div>
        <h1 style="font-size: 2.5rem; display: flex; align-items: center; gap: 15px;">
            <span><?= $info['icon'] ?></span>
            <?= $info['titulo'] ?>
        </h1>
        <p class="text-muted">Gerenciamento de fluxos de ouvidoria de nível institucional.</p>
    </div>

    <div style="flex: 1; max-width: 400px; position: relative;">
        <input type="text" id="tableSearch" class="form-control"
            placeholder="🔍 Filtrar por assunto, protocolo ou manifestante..."
            style="padding-left: 1rem; border-radius: 12px; background: white;">
    </div>
</div>

<div class="card" style="border: none; box-shadow: var(--shadow-lg);">
    <div class="table-responsive">
        <table class="table" id="mainTable">
            <thead>
                <tr>
                    <th style="border-radius: 12px 0 0 0;">Protocolo</th>
                    <th>Assunto / Conteúdo</th>
                    <th>Tipo</th>
                    <th>Data</th>
                    <th>Status Local</th>
                    <th style="border-radius: 0 12px 0 0; text-align: right;">Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($manifestacoes)): ?>
                    <tr>
                        <td colspan="6" class="text-center" style="padding: 5rem 2rem;">
                            <div style="font-size: 3rem; opacity: 0.2; margin-bottom: 1rem;">📁</div>
                            <h3 class="text-muted">Nenhum registro encontrado nesta categoria.</h3>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($manifestacoes as $m): ?>
                        <tr class="searchable-row">
                            <td style="font-weight: 800; color: var(--vox-green-dark); font-size: 0.85rem;">
                                <?= htmlspecialchars($m['registro']) ?>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: var(--slate-900); margin-bottom: 0.25rem;">
                                    <?= htmlspecialchars(mb_substr($m['assunto'] ?? '', 0, 60)) ?>        <?= mb_strlen($m['assunto'] ?? '') > 60 ? '...' : '' ?>
                                </div>
                                <div style="font-size: 0.8rem; color: var(--slate-400);">
                                    <?= htmlspecialchars($m['nome_clientela'] ?? 'Público Geral') ?> •
                                    <?php if ($m['forma_identificacao'] === 'A'): ?>
                                        <span style="color: var(--color-danger);">Anônimo</span>
                                    <?php else: ?>
                                        <span><?= htmlspecialchars($m['nome'] ?? 'Identificado') ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="background: var(--slate-100); color: var(--slate-600);">
                                    <?= htmlspecialchars($m['nome_tipo'] ?? 'Outros') ?>
                                </span>
                            </td>
                            <td style="color: var(--slate-500); font-size: 0.85rem;">
                                <?= $m['data_criacao'] ? date('d/m/Y', strtotime($m['data_criacao'])) : '-' ?>
                            </td>
                            <td>
                                <?php if ($tipo === 'andamento'): ?>
                                    <div style="font-size: 0.75rem; color: var(--vox-green-dark); line-height: 1.2;">
                                        <strong>Setores envolvidos:</strong><br>
                                        <?= htmlspecialchars(mb_substr($m['departamentos'] ?? 'Nenhum', 0, 30)) ?>
                                    </div>
                                <?php else: ?>
                                    <span class="badge" style="background: <?= $info['color'] ?>; color: white;">
                                        <?= htmlspecialchars($m['nome_status']) ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right;">
                                <a href="/admin/detalhes?id=<?= $m['manifestacao_id'] ?>" class="btn btn-sm btn-primary"
                                    style="padding: 0.5rem 1.25rem; border-radius: 10px;">
                                    Gerenciar →
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('tableSearch').addEventListener('keyup', function () {
        const term = this.value.toLowerCase();
        const rows = document.querySelectorAll('.searchable-row');

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(term) ? '' : 'none';
        });
    });
</script>