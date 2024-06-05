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
                        <th>Marca</th>
                        <th>Ubicación</th>
                        <th>Stock/kg</th>
                        <th>Stock Crítico/kg</th>
                        <th>Precio/kg</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($materia_prima) {
                        foreach ($materia_prima as $row) {
                            $ubicacion = $row['Ubicacion_Piso'] . ', ' . $row['Ubicacion_Mueble'] . ', ' . $row['Ubicacion_Repisa'];
                            $precio_por_unidad = $row['Precio'] . ' pesos/kg';
                            echo "<tr>
                                    <td><a href='proveedores.php?cod_barras={$row['COD_BARRAS']}'>{$row['Nombre']}</a></td>
                                    <td>{$row['Unidad_Medida']}</td>
                                    <td>{$row['Marca']}</td>
                                    <td>{$ubicacion}</td>
                                    <td>{$row['Stock']}/kg</td>
                                    <td>{$row['Stock_Critico']}/kg</td>
                                    <td>{$precio_por_unidad}</td>
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
            <a href="../pages/ingresos.php" class="btn">Ingreso</a>
            <a href="../pages/salidas.php" class="btn">Salida</a>
        </div>
    </div>
</body>
</html>
