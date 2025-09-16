<script>
function applyCpfMask(value) {
    let numbers = value.replace(/\D/g, '');
    
    switch (true) {
        case numbers.length <= 3:
            return numbers;
        case numbers.length <= 6:
            return numbers.substring(0, 3) + '.' + numbers.substring(3);
        case numbers.length <= 9:
            return numbers.substring(0, 3) + '.' + numbers.substring(3, 6) + '.' + numbers.substring(6);
        default:
            return numbers.substring(0, 3) + '.' + numbers.substring(3, 6) + '.' + numbers.substring(6, 9) + '-' + numbers.substring(9, 11);
    }
}

function openCreateModal() {
    document.getElementById('createModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    setTimeout(function() {
        setupContactMasks();
        setupCpfMask();
    }, 100);
}

function setupCpfMask() {
    const cpfInput = document.getElementById('cpf');
    
    if (cpfInput) {
        cpfInput.addEventListener('input', function(e) {
            const cursorPosition = e.target.selectionStart;
            const oldValue = e.target.value;
            const newValue = applyCpfMask(e.target.value);
            
            e.target.value = newValue;
            
            const lengthDiff = newValue.length - oldValue.length;
            e.target.setSelectionRange(cursorPosition + lengthDiff, cursorPosition + lengthDiff);
        });
        
        cpfInput.setAttribute('maxlength', '14');
    }
}

function setupContactMasks() {
    const typeSelect = document.getElementById('type');
    const contactInput = document.getElementById('description');
    
    if (!typeSelect || !contactInput) {
        return;
    }
    
    function applyMask() {
        const selectedType = typeSelect.value;
        
        contactInput.removeAttribute('maxlength');
        contactInput.setAttribute('type', 'text');
        contactInput.value = '';
        
        switch (selectedType) {
            case 'Telefone':
                contactInput.setAttribute('placeholder', 'Digite o telefone');
                break;
            case 'Email':
                contactInput.setAttribute('type', 'email');
                contactInput.setAttribute('placeholder', 'Digite o email (ex: usuario@exemplo.com)');
                break;
            default:
                contactInput.setAttribute('placeholder', 'Selecione o tipo primeiro');
        }
    }
    
    typeSelect.addEventListener('change', applyMask);
}

function applyContactMask(selectElement) {
    const inputElement = document.getElementById('description');
    const selectedType = selectElement.value;
    
    if (!inputElement) {
        return;
    }
    
    inputElement.removeAttribute('maxlength');
    inputElement.setAttribute('type', 'text');
    inputElement.value = '';
    
    switch (selectedType) {
        case 'Telefone':
            inputElement.setAttribute('placeholder', 'Digite o telefone');
            break;
        case 'Email':
            inputElement.setAttribute('type', 'email');
            inputElement.setAttribute('placeholder', 'Digite o email (ex: usuario@exemplo.com)');
            break;
        default:
            inputElement.setAttribute('placeholder', 'Selecione o tipo primeiro');
    }
}

function closeCreateModal() {
    document.getElementById('createModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    const form = document.getElementById('createForm');
    if (form) {
        form.reset();
    }
}

function openDeleteModal(url, itemName) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    const message = document.getElementById('deleteMessage');
    
    form.action = url;
    message.textContent = 'Você está prestes a excluir: ' + itemName + '. Esta ação não pode ser desfeita!';
    
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

document.addEventListener('DOMContentLoaded', function() {
    const createForm = document.getElementById('createForm');
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitFormAjax();
        });
    }
});

function submitFormAjax() {
    const form = document.getElementById('createForm');
    const formData = new FormData(form);
    const submitButton = form.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    submitButton.innerHTML = '⏳ Salvando...';
    submitButton.disabled = true;

    fetch('<?= htmlspecialchars($createUrl) ?>', {
        method: 'POST',
        body: formData,
        redirect: 'follow'
    })
    .then(response => {
        if (response.redirected) {
            window.location.href = response.url;
            return;
        }
        return response.text();
    })
    .then(data => {
        if (!data) return;
        if (data.includes('error') || data.includes('Erro')) {
            document.dispatchEvent(new CustomEvent('toast:error', { detail: 'Verifique os dados e tente novamente.' }));
        } else {
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        document.dispatchEvent(new CustomEvent('toast:error', { detail: error.message }));
    })
    .finally(() => {
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
}

window.onclick = function(event) {
    const createModal = document.getElementById('createModal');
    const deleteModal = document.getElementById('deleteModal');
    
    if (event.target === createModal) {
        closeCreateModal();
    }
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeCreateModal();
        closeDeleteModal();
    }
});
</script>
