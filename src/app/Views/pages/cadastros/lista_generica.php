<?php
$labels = [
    'departamento' => ['titulo' => 'Setores / Departamentos', 'urlSalvar' => '/admin/departamentos/salvar', 'urlExcluir' => '/admin/departamentos/excluir'],
    'tipo' => ['titulo' => 'Categorias de Manifestação', 'urlSalvar' => '/admin/tipos/salvar', 'urlExcluir' => '/admin/tipos/excluir'],
    'clientela' => ['titulo' => 'Segmentos de Clientela', 'urlSalvar' => '/admin/clientelas/salvar', 'urlExcluir' => '/admin/clientelas/excluir'],
    'status' => ['titulo' => 'Estados do Processo', 'urlSalvar' => '/admin/statuses/salvar', 'urlExcluir' => '/admin/statuses/excluir'],
    'usuario' => ['titulo' => 'Equipe Administrativa', 'urlSalvar' => '/admin/usuarios/salvar', 'urlExcluir' => '/admin/usuarios/excluir'],
];
$info = $labels[$tipo] ?? [];
$idField = array_key_first($campos);
?>

<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2.5rem;">
    <h1>
        <?= $info['titulo'] ?? 'Cadastro' ?>
    </h1>
    <button class="btn btn-primary" onclick="showCreateForm()">
        ✨ Adicionar Novo
    </button>
</div>

<!-- Modal / Form de Cadastro -->
<div id="formNovo" class="card"
    style="display:none; border: 2px solid var(--vox-green); margin-bottom: 3rem; animation: slideDown 0.3s ease;">
    <div class="card-header" style="background: var(--vox-green-light); font-weight: 800;">
        📝 <span id="formTitle">Novo Registro</span>
    </div>
    <div class="card-body">
        <form method="post" action="<?= $info['urlSalvar'] ?? '' ?>" id="genericForm">
            <input type="hidden" name="id" value="" id="editId">

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <?php foreach ($campos as $field => $label): ?>
                    <?php if ($field === $idField)
                        continue; ?>
                    <div>
                        <label
                            style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--slate-600); margin-bottom: 0.5rem;">
                            <?= htmlspecialchars($label) ?>
                        </label>

                        <?php if ($field === 'visivel'): ?>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="checkbox" name="visivel" id="input_visivel" checked> Sim
                            </label>
                        <?php elseif ($field === 'descricao'): ?>
                            <textarea name="<?= $field ?>" id="input_<?= $field ?>" class="form-control" rows="2"></textarea>
                        <?php elseif ($field === 'senha'): ?>
                            <input type="password" name="<?= $field ?>" class="form-control"
                                placeholder="Mudar senha (ou deixe vazio)">
                        <?php else: ?>
                            <input type="text" name="<?= $field ?>" id="input_<?= $field ?>" class="form-control" required>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div
                style="display: flex; gap: 10px; margin-top: 2rem; border-top: 1px solid var(--slate-100); padding-top: 1.5rem;">
                <button type="submit" class="btn btn-primary" style="padding-left: 2.5rem; padding-right: 2.5rem;">💾
                    Gravar Dados</button>
                <button type="button" class="btn btn-secondary" onclick="hideForm()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- Listagem Card -->
<div class="card" style="border: none; box-shadow: var(--shadow-lg);">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <?php foreach ($campos as $label): ?>
                        <th>
                            <?= htmlspecialchars($label) ?>
                        </th>
                    <?php endforeach; ?>
                    <th style="text-align: right;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($items)): ?>
                    <tr>
                        <td colspan="<?= count($campos) + 1 ?>" class="text-center" style="padding: 4rem;">
                            <p class="text-muted">Nenhum registro encontrado.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <?php foreach ($campos as $field => $label): ?>
                                <td style="<?= $field === $idField ? 'font-weight: 800; color: var(--slate-400);' : '' ?>">
                                    <?php if ($field === 'visivel'): ?>
                                        <?= $item[$field] ? '✅' : '❌' ?>
                                    <?php else: ?>
                                        <?= htmlspecialchars((string) ($item[$field] ?? '')) ?>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                            <td style="text-align: right;">
                                <div style="display: flex; gap: 5px; justify-content: flex-end;">
                                    <button class="btn btn-sm btn-secondary" style="padding: 5px 12px;"
                                        onclick='editItem(<?= json_encode($item) ?>)'>Editar</button>

                                    <form method="post" action="<?= $info['urlExcluir'] ?? '' ?>" style="display:inline;"
                                        onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                        <input type="hidden" name="id" value="<?= $item[$idField] ?>">
                                        <button type="submit" class="btn btn-sm btn-block"
                                            style="background: #fee2e2; color: #991b1b; padding: 5px 12px;">Excluir</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function showCreateForm() {
        document.getElementById('editId').value = '';
        document.getElementById('formTitle').innerText = 'Novo Registro';
        document.getElementById('genericForm').reset();
        document.getElementById('formNovo').style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function hideForm() {
        document.getElementById('formNovo').style.display = 'none';
    }

    function editItem(data) {
        document.getElementById('formTitle').innerText = 'Editando Registro #' + data['<?= $idField ?>'];
        document.getElementById('editId').value = data['<?= $idField ?>'];

        // Auto-preenchimento dos campos
        for (let key in data) {
            let input = document.getElementById('input_' + key);
            if (input) {
                if (input.type === 'checkbox') {
                    input.checked = !!data[key];
                } else {
                    input.value = data[key];
                }
            }
        }

        document.getElementById('formNovo').style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>

<style>
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>