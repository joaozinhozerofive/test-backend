<div class="edit-container">
    <div class="edit-card">
        <form method="POST" action="/persons/create" id="personForm">
            <div class="form-group">
                <label for="name">Nome Completo *</label>
                <input type="text" id="name" name="name" placeholder="Digite o nome completo da pessoa" required>
            </div>
            
            <div class="form-group">
                <label for="cpf">CPF *</label>
                <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required>
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                    ❌ Cancelar
                </button>
                <button type="submit" class="btn btn-success">
                    ✅ Salvar Pessoa
                </button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../../partials/components/cpf-mask-js.php'; ?>
