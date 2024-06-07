<?php
include '../includes/Consulta_Materia_Prima.php'; 
include '../templates/menu.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Materia Prima</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/Consultas.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="table-container">
            <h2>Lista de Materia Prima</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Unidad de Medida</th>
                        <th>Ubicación</th>
                        <th>Stock</th>
                        <th>Stock mínimo</th>
                        <th>Stock/Unidad Medida</th>
                        <th>Precio/Unidad Medida</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($materia_prima) {
                        foreach ($materia_prima as $row) {
                            $ubicacion = $row['Ubicacion_Piso'] . ', ' . $row['Ubicacion_Mueble'] . ', ' . $row['Ubicacion_Repisa'];
                            echo "<tr>
                                    <td><a href='proveedores.php?cod_barras={$row['COD_BARRAS']}'>{$row['Nombre']}</a></td>
                                    <td>{$row['Unidad_Medida_Pack']}</td>
                                    <td>{$ubicacion}</td>
                                    <td>{$row['Stock']} {$row['Unidad_Medida_Pack']}</td>
                                    <td>{$row['Stock_Critico']} {$row['Unidad_Medida_Pack']}</td>
                                    <td>{$row['Stock_Unidad']} {$row['Unidad_Medida']}</td>
                                    <td>{$row['Precio_Unidad']} pesos/{$row['Unidad_Medida']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No se encontraron resultados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="links">
            <a href="../pages/transacciones.php" class="btn">Ingreso</a>
            <a href="../pages/salidas.php" class="btn">Salida</a>
        </div>
    </div>
</body>
</html>
