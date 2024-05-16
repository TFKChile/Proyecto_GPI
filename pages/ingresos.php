<?php include '../templates/menu.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingresar Datos al Inventario</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/Styles.css">
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
            <input type="text" id="telefono" name="telefono" required>
        </div>
        <div>
            <label for="mail">Correo Electrónico (opcional):</label>
            <input type="email" id="mail" name="mail">
        </div>
        <div>
            <label for="cod_barras">Codigo de barras:</label>
            <input type="text" id="cod_barras" name="cod_barras" required>
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
            <input type="number" id="stock_critico" name="stock_critico" required>
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
