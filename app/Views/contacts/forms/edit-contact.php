<div class="edit-container">
    <div class="edit-card">
        <form method="POST" action="/contacts/edit/<?= $contactId ?>" id="contactForm">
            <input type="hidden" name="_method" value="PUT">
            
            <div class="form-group">
                <label for="person_id">Pessoa</label>
                <select id="person_id" name="person_id" disabled>
                    <option value="<?= $personId ?>" selected><?= $personName ?></option>
                </select>
                <small class="form-text">A pessoa não pode ser alterada ao editar um contato.</small>
            </div>
            
            <div class="contacts-section">
                <div class="section-header">
                    <h3>📞 Contato</h3>
                </div>
                
                <div id="contacts-container">
                    <div class="contact-item">
                        <div class="contact-header">
                            <span class="contact-label">Contato 1</span>
                        </div>
                        <div class="contact-fields">
                            <div class="form-group">
                                <label>Tipo *</label>
                                <select name="type" required onchange="applyContactMaskEdit(this)">
                                    <?php foreach ($validTypes as $value => $label): ?>
                                        <option value="<?= $value ?>" <?= ($contactType === $value) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($label) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Contato *</label>
                                <input type="text" name="description" value="<?= $contactDescription ?>" required placeholder="Selecione o tipo primeiro">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                    ❌ Cancelar
                </button>
                <button type="submit" class="btn btn-success">
                    ✅ Salvar Contato
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const typeSelect = document.querySelector("select[name=\"type\"]");
    const inputElement = document.querySelector("input[name=\"description\"]");
    
    if (typeSelect && inputElement) {
        const selectedType = typeSelect.value;
        
        switch (selectedType) {
            case "Telefone":
                inputElement.setAttribute("placeholder", "Digite o telefone");
                break;
            case "Email":
                inputElement.setAttribute("type", "email");
                inputElement.setAttribute("placeholder", "Digite o email (ex: usuario@exemplo.com)");
                break;
        }
    }
});

function applyContactMaskEdit(selectElement) {
    const inputElement = document.querySelector("input[name=\"description\"]");
    const selectedType = selectElement.value;
    
    if (!inputElement) {
        return;
    }
    
    inputElement.removeAttribute("maxlength");
    inputElement.setAttribute("type", "text");
    
    inputElement.value = "";
    
    switch (selectedType) {
        case "Telefone":
            inputElement.setAttribute("placeholder", "Digite o telefone");
            break;
        case "Email":
            inputElement.setAttribute("type", "email");
            inputElement.setAttribute("placeholder", "Digite o email (ex: usuario@exemplo.com)");
            break;
        default:
            inputElement.setAttribute("placeholder", "Selecione o tipo primeiro");
    }
}
</script>
