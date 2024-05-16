<?php include '../templates/menu.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>salida Transacción</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/transaccion.css">
</head>
<body>
    <h2>Transacciones de salida</h2>
    <form class="formulario" action="../includes/salida_transacciones.php" method="post">
        <div>
            <label for="cod_barras">Código de Barras:</label>
            <input type="number" id="cod_barras" name="cod_barras" required>
        </div>        
        <div>
            <label for="cantidad_Salida">Cantidad de salida:</label>
            <input type="number" id="cantidad_Salida" name="cantidad_Salida" required>
        </div>
        <div>
            <input type="submit" value="Insertar">
        </div>
    </form>
</body>
</html>
