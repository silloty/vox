<div style="margin-bottom: 3rem;">
    <h1 style="font-size: 2.75rem; letter-spacing: -0.02em;">Central de Comando</h1>
    <p class="text-muted" style="font-size: 1.15rem;">Bem-vindo(a),
        <strong><?= htmlspecialchars($nomeUsuario) ?></strong>. Aqui está o panorama da sua Ouvidoria hoje.</p>
</div>

<div class="stats-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 4rem;">
    <a href="/admin/abertas" style="text-decoration: none;">
        <div class="card"
            style="padding: 2.5rem; transition: transform 0.2s; border: none; background: #eff6ff; color: #1e40af;">
            <div
                style="font-size: 0.85rem; font-weight: 800; text-transform: uppercase; margin-bottom: 1rem; opacity: 0.7;">
                ⚠️ Novas/Abertas</div>
            <div style="font-size: 3.5rem; font-weight: 900; line-height: 1;"><?= $totalAbertas ?></div>
            <div style="margin-top: 1rem; font-weight: 600;">Registros Pendentes →</div>
        </div>
    </a>

    <a href="/admin/andamento" style="text-decoration: none;">
        <div class="card"
            style="padding: 2.5rem; transition: transform 0.2s; border: none; background: #fffbeb; color: #92400e;">
            <div
                style="font-size: 0.85rem; font-weight: 800; text-transform: uppercase; margin-bottom: 1rem; opacity: 0.7;">
                ⏳ Em Tratativa</div>
            <div style="font-size: 3.5rem; font-weight: 900; line-height: 1;"><?= $totalAndamento ?></div>
            <div style="margin-top: 1rem; font-weight: 600;">Ver Andamentos →</div>
        </div>
    </a>

    <a href="/admin/fechadas" style="text-decoration: none;">
        <div class="card"
            style="padding: 2.5rem; transition: transform 0.2s; border: none; background: #f0fdf4; color: #166534;">
            <div
                style="font-size: 0.85rem; font-weight: 800; text-transform: uppercase; margin-bottom: 1rem; opacity: 0.7;">
                ✅ Concluídas</div>
            <div style="font-size: 3.5rem; font-weight: 900; line-height: 1;"><?= $totalFechadas ?></div>
            <div style="margin-top: 1rem; font-weight: 600;">Histórico Completo →</div>
        </div>
    </a>
</div>

<div class="grid-2 gap-4">
    <div class="card">
        <div class="card-header">📊 Configurações do Sistema</div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <a href="/admin/departamentos" class="btn btn-secondary btn-block"
                    style="background: var(--slate-100);">🏢 Setores</a>
                <a href="/admin/tipos" class="btn btn-secondary btn-block" style="background: var(--slate-100);">📋
                    Categorias</a>
                <a href="/admin/clientelas" class="btn btn-secondary btn-block" style="background: var(--slate-100);">👥
                    Segmentos</a>
                <a href="/admin/usuarios" class="btn btn-secondary btn-block" style="background: var(--slate-100);">👤
                    Equipe</a>
            </div>
        </div>
    </div>

    <div class="card" style="background: var(--vox-green); color: white; border: none;">
        <div class="card-header" style="background: rgba(0,0,0,0.1); color: white; border: none;">💡 Atalho Útil</div>
        <div class="card-body">
            <p style="margin-bottom: 2rem; opacity: 0.9;">Deseja simular um novo registro ou testar o formulário que o
                cidadão acessa?</p>
            <a href="/manifestacao" target="_blank" class="btn"
                style="background: white; color: var(--vox-green-dark); width: 100%; font-weight: 800;">
                Abrir Portal Público ↗
            </a>
        </div>
    </div>
</div>