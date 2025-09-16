<div class="home-container">
    <div class="welcome-section">
        <h1>📋 Sistema de Contatos</h1>
        <p>Gerencie pessoas e seus contatos de forma simples e eficiente</p>
    </div>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-number"><?= $totalPersons ?></div>
            <div class="stat-label">Pessoas Cadastradas</div>
            <a href="/persons" class="stat-link">Ver Pessoas →</a>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">📞</div>
            <div class="stat-number"><?= $totalContacts ?></div>
            <div class="stat-label">Contatos Cadastrados</div>
            <a href="/contacts" class="stat-link">Ver Contatos →</a>
        </div>
    </div>
    
    <div class="actions-grid">
        <div class="action-card">
            <h3>👥 Gerenciar Pessoas</h3>
            <p>Cadastre, visualize, edite e exclua pessoas do sistema</p>
            <div class="action-buttons">
                <a href="/persons" class="btn btn-primary">Ver Pessoas</a>
            </div>
        </div>
        
        <div class="action-card">
            <h3>📞 Gerenciar Contatos</h3>
            <p>Cadastre, visualize, edite e exclua contatos das pessoas</p>
            <div class="action-buttons">
                <a href="/contacts" class="btn btn-primary">Ver Contatos</a>
            </div>
        </div>
    </div>
</div>
