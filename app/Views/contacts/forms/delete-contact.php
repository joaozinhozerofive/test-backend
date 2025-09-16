<div class="confirmation-container">
    <div class="confirmation-card">
        <div class="confirmation-icon">⚠️</div>
        <h2>Tem certeza?</h2>
        <p>Você está prestes a excluir o contato:</p>
        <p><strong><?= $type ?>: <?= $description ?></strong></p>
        <p>da pessoa: <strong><?= $personName ?></strong></p>
        <p>Esta ação não pode ser desfeita!</p>
        
        <div class="confirmation-actions">
            <a href="/contacts" class="btn btn-secondary">
                ❌ Cancelar
            </a>
            <form method="POST" action="/contacts/delete/<?= $id ?>" class="inline-form">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-danger">
                    ✅ Confirmar Exclusão
                </button>
            </form>
        </div>
    </div>
</div>
