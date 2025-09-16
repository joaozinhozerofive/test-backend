<div class="edit-container">
    <div class="edit-card">
        <form method="POST" action="/persons/edit/<?= $id ?>" id="personForm">
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
                <label for="name">Nome Completo *</label>
                <input type="text" id="name" name="name" value="<?= $name ?>" required>
            </div>
            
            <div class="form-group">
                <label for="cpf">CPF *</label>
                <input type="text" id="cpf" name="cpf" value="<?= $cpf ?>" required>
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                    ❌ Cancelar
                </button>
                <button type="submit" class="btn btn-success">
                    ✅ Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../../partials/components/cpf-mask-js.php'; ?>

