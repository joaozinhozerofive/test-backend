<div class="view-container">
    <div class="person-card">
        <div class="person-header">
            <h2><?= ($type === 'Telefone' ? '📞' : '📧') ?> <?= $type ?></h2>
            <span class="person-id">ID: <?= $id ?></span>
        </div>
        
        <div class="person-details">
            <div class="detail-group">
                <label>Pessoa:</label>
                <span><?= $personName ?></span>
            </div>
            
            <div class="detail-group">
                <label>Tipo:</label>
                <span><?= $type ?></span>
            </div>
            
            <div class="detail-group">
                <label>Contato:</label>
                <span>
                    <?php if ($type === 'Email'): ?>
                        <a href="mailto:<?= $description ?>" style="color: #60a5fa; text-decoration: none;"><?= $description ?></a>
                    <?php else: ?>
                        <a href="tel:<?= $description ?>" style="color: #4ade80; text-decoration: none;"><?= $formattedDescription ?></a>
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </div>
</div>
