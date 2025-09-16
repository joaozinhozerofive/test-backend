<div class="view-container">
    <div class="person-card">
        <div class="person-header">
            <h2><?= $name ?></h2>
            <span class="person-id">ID: <?= $id ?></span>
        </div>
        
        <div class="person-details">
            <div class="detail-group">
                <label>Nome Completo:</label>
                <span><?= $name ?></span>
            </div>
            
            <div class="detail-group">
                <label>CPF:</label>
                <span><?= $cpf ?></span>
            </div>
            
            <div class="detail-group">
                <label>Total de Contatos:</label>
                <span class="contacts-count"><?= $contactsCount ?></span>
            </div>
        </div>
        
        <div class="contacts-section">
            <h3>📞 Contatos</h3>
            <div class="contacts-list">
                <?php if ($contacts->count() > 0): ?>
                    <?php foreach ($contacts as $contact): ?>
                        <div class="contact-item">
                            <span class="contact-type"><?= htmlspecialchars($contact->getType()) ?>:</span>
                            <span class="contact-description"><?= htmlspecialchars($contact->getDescription()) ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-contacts">Nenhum contato cadastrado.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
