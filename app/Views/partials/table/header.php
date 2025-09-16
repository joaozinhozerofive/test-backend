<div class="header">
    <div class="header-content">
        <h1><?= htmlspecialchars($title) ?></h1>
        <p><?= htmlspecialchars($subtitle) ?></p>
        <?php if (!empty($formFields) && !empty($createUrl)): ?>
            <div class="header-actions">
                <button class="btn btn-primary" onclick="openCreateModal()">
                    ➕ Adicionar Registro
                </button>
            </div>
        <?php endif; ?>
    </div>
</div>
