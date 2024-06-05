<?php include '../templates/menu.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingresar Transacción</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/transaccion.css">
    <script src="../assets/js/validacion.js"></script>
</head>
<body>
    <h2>Ingresar Transacción</h2>
    <form class="formulario" action="../includes/ingreso_transaccioens.php" method="post">
        <div>
            <label for="cod_barras">Código de Barras:</label>
            <input type="text" id="cod_barras" name="cod_barras" pattern="[0-9]+" required>
        </div>        
        <div>
            <label for="cantidad_compra">Cantidad de Compra:</label>
            <input type="text" id="cantidad_compra" name="cantidad_compra" pattern="[0-9]+" required>
        </div>
        <div>
            <label for="precio_compra">Precio de Compra:</label>
            <input type="text" id="precio_compra" name="precio_compra" pattern="[0-9]+" required>
        </div>
        <div>
            <input type="submit" value="Ingresar">
        </div>
    </form>

</body>
</html>

