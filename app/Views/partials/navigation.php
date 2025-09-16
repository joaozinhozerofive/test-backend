<nav class="main-nav">
    <div class="nav-container">
        <div class="nav-brand">
            <a href="/" class="brand-link">
                <h1>📋 Sistema de Contatos</h1>
            </a>
        </div>
        <div class="nav-menu">
            <a href="/" class="nav-link <?= $currentPage === 'home' ? 'active' : '' ?>">
                🏠 Home
            </a>
            <a href="/persons" class="nav-link <?= $currentPage === 'persons' ? 'active' : '' ?>">
                👥 Pessoas
            </a>
            <a href="/contacts" class="nav-link <?= $currentPage === 'contacts' ? 'active' : '' ?>">
                📞 Contatos
            </a>
        </div>
    </div>
</nav>
