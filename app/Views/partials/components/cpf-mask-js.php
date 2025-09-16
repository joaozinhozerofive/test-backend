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

function initCpfMask(inputId) {
    var id = inputId || 'cpf';
    var cpfInput = document.getElementById(id);
    
    if (!cpfInput) {
        return;
    }
    
    cpfInput.addEventListener('input', function(e) {
        var cursorPosition = e.target.selectionStart;
        var oldValue = e.target.value;
        var newValue = applyCpfMask(e.target.value);
        
        e.target.value = newValue;
        
        var lengthDiff = newValue.length - oldValue.length;
        e.target.setSelectionRange(cursorPosition + lengthDiff, cursorPosition + lengthDiff);
    });
    
    cpfInput.setAttribute('maxlength', '14');
}

document.addEventListener('DOMContentLoaded', function() {
    initCpfMask('cpf');
});
</script>


