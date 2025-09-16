<div class="edit-container">
    <div class="edit-card">
        <form method="POST" action="/contacts/create" id="contactForm">
            <?php if (!empty($redirectTo)): ?>
                <input type="hidden" name="redirect_to" value="<?= htmlspecialchars($redirectTo) ?>">
            <?php endif; ?>
            <div class="form-group">
                <label for="person_id">Pessoa *</label>
                <select id="person_id" name="person_id" required>
                    <option value="">Selecione...</option>
                    <?php foreach ($personsChoices as $id => $name): ?>
                        <option value="<?= $id ?>" <?= (isset($selectedPersonId) && $selectedPersonId == $id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="contacts-section">
                <div class="section-header">
                    <h3>📞 Contatos</h3>
                    <button type="button" class="btn btn-primary btn-sm" onclick="addContact()">
                        ➕ Adicionar Contato
                    </button>
                </div>
                
                <div id="contacts-container">
                </div>
                
                <div class="contacts-help">
                    <small class="text-muted">
                        💡 <strong>Dica:</strong> Você pode adicionar múltiplos contatos (telefones e emails) para a mesma pessoa.
                    </small>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                    ❌ Cancelar
                </button>
                <button type="submit" class="btn btn-success">
                    ✅ Salvar Contatos
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let contactIndex = 0;

function applyContactMaskDynamic(selectElement) {
    const contactItem = selectElement.closest(".contact-item");
    const inputElement = contactItem.querySelector("input[name*=\"[description]\"]");
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

function addContact() {
    const container = document.getElementById("contacts-container");
    const contactDiv = document.createElement("div");
    contactDiv.className = "contact-item";
    contactDiv.innerHTML = `
        <div class="contact-header">
            <span class="contact-label">Contato ${contactIndex + 1}</span>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeContact(this)">
                🗑️ Remover
            </button>
        </div>
        <div class="contact-fields">
            <div class="form-group">
                <label>Tipo *</label>
                <select name="contacts[${contactIndex}][type]" required onchange="applyContactMaskDynamic(this)">
                    <option value="">Selecione...</option>
                    <option value="Telefone">Telefone</option>
                    <option value="Email">Email</option>
                </select>
            </div>
            <div class="form-group">
                <label>Contato *</label>
                <input type="text" name="contacts[${contactIndex}][description]" placeholder="Selecione o tipo primeiro" required>
            </div>
        </div>
    `;
    
    container.appendChild(contactDiv);
    contactIndex++;
}

function removeContact(button) {
    const contactItem = button.closest(".contact-item");
    contactItem.remove();
    reindexContacts();
}

function reindexContacts() {
    const contacts = document.querySelectorAll(".contact-item");
    contactIndex = 0;
    
    contacts.forEach((contact, index) => {
        const header = contact.querySelector(".contact-label");
        header.textContent = `Contato ${index + 1}`;
        
        const typeSelect = contact.querySelector("select[name^=\"contacts[\"]");
        const descriptionInput = contact.querySelector("input[name^=\"contacts[\"]");
        
        if (typeSelect && descriptionInput) {
            typeSelect.name = `contacts[${index}][type]`;
            descriptionInput.name = `contacts[${index}][description]`;
        }
        
        contactIndex = index + 1;
    });
}

document.addEventListener("DOMContentLoaded", function() {
    addContact();
});
</script>
