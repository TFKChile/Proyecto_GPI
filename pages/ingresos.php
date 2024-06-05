<?php include '../templates/menu.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingresar Datos al Inventario</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/Styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
    <script src="../assets/js/script.js"></script>
</head>
<body>
    <h2>Ingresar Datos al Inventario</h2>
    <form class="formulario" action="../includes/Ingreso_datos.php" method="post">
        <div>
            <label for="nombre_proveedor">Nombre del Proveedor:</label>
            <input type="text" id="nombre_proveedor" name="nombre_proveedor" required>
        </div>
        <div>
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" pattern="[0-9]+" required>
        </div>
        <div>
            <label for="mail">Correo Electrónico (opcional):</label>
            <input type="email" id="mail" name="mail">
        </div>
        <div>
            <label for="cod_barras">Codigo de barras:</label>
            <input type="text" id="cod_barras" name="cod_barras" pattern="[0-9]+" required>
        </div>
        <div>
            <label for="nombre_materia_prima">Nombre de la Materia Prima:</label>
            <input type="text" id="nombre_materia_prima" name="nombre_materia_prima" required>
        </div>
        <div>
            <label for="unidad_medida">Unidad de Medida:</label>
            <input type="text" id="unidad_medida" name="unidad_medida" required>
        </div>
        <div>
            <label for="stock_critico">Stock Crítico:</label>
            <input type="text" id="stock_critico" name="stock_critico" pattern="[0-9]+" required>
        </div>
        <div>
            <label for="ubicacion">Ubicación:</label>
            <input type="text" id="ubicacion" name="ubicacion" required>
        </div>
        <div>
            <input type="submit" value="Insertar">
        </div>
    </form>
</body>
</html>
