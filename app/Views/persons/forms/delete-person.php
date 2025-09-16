<div class="confirmation-container">
    <div class="confirmation-card">
        <div class="confirmation-icon">⚠️</div>
        <h2>Tem certeza?</h2>
        <p>Você está prestes a excluir a pessoa: <strong><?= $name ?></strong></p>
        <?php if ($contactsCount > 0): ?>
            <p><strong>Atenção:</strong> Esta pessoa possui <?= $contactsCount ?> contato(s) que também será(ão) excluído(s) permanentemente!</p>
        <?php endif; ?>
        <p>Esta ação não pode ser desfeita!</p>
        <p>A pessoa será permanentemente removida do sistema.</p>
        
        <div class="confirmation-actions">
            <a href="/persons" class="btn btn-secondary">
                ❌ Cancelar
            </a>
            <form method="POST" action="/persons/delete/<?= $id ?>" class="inline-form">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-danger">
                    ✅ Confirmar Exclusão
                </button>
            </form>
        </div>
    </div>
</div>
