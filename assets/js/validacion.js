function Validacion_numero(event) {
    var input = event.target;
    if (!/^\d*$/.test(input.value)) {
        input.value = input.value.replace(/[^\d]/g, '');
    }
}

document.getElementById('telefono').addEventListener('input', Validacion_numero);
document.getElementById('cod_barras').addEventListener('input', Validacion_numero);
document.getElementById('stock_critico').addEventListener('input', Validacion_numero);
document.getElementById('cantidad_Salida').addEventListener('input', Validacion_numero);
document.getElementById('cantidad_compra').addEventListener('input', Validacion_numero);
document.getElementById('precio_compra').addEventListener('input', Validacion_numero);