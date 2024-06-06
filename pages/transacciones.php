<?php include '../templates/menu.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Transacciones de Salida</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/transaccion.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
    <script src="../assets/js/validacion.js"></script>
</head>
<body>
    <h2>Transacciones</h2>
    <form class="formulario" action="../includes/ingreso_transacciones.php" method="post">
        <div>
            <label for="cod_barras">Código de Barras:</label>
            <input type="text" id="cod_barras" name="cod_barras" pattern="[0-9]+" required>
        </div>        
        <div>
            <label for="precio_compra">Precio Compra:</label>
            <input type="text" id="precio_compra" name="precio_compra" pattern="[0-9]+" required>
        </div>
        <div>
            <label for="cantidad_compra">Cantidad de compra</label>
            <input type="text" id="cantidad_compra" name="cantidad_compra" pattern="[0-9]+" required>
        </div>
        <div>
            <input type="submit" value="Insertar">
        </div>
    </form>
</body>
</html>
