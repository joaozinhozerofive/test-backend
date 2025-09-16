<script>
function applyContactMask(selectElement) {
    const inputElement = document.getElementById(selectElement.id.replace("_type", ""));
    const selectedType = selectElement.value;
    
    if (!inputElement) {
        console.error("Campo de contato não encontrado para:", selectElement.id);
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
