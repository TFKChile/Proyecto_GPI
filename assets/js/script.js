function validateNumericInput(event) {
    var input = event.target;
    if (!/^\d*$/.test(input.value)) {
        input.value = input.value.replace(/[^\d]/g, '');
    }
}

document.getElementById('telefono').addEventListener('input', validateNumericInput);
document.getElementById('cod_barras').addEventListener('input', validateNumericInput);
document.getElementById('stock_critico').addEventListener('input', validateNumericInput);
