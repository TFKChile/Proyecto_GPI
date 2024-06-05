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
                        <th>Stock</th>
                        <th>Stock Crítico</th>
                        <th>Unidad de Medida</th>
                        <th>Ubicación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mostrar primero los productos con stock menor que el stock crítico
                    if ($materia_prima) {
                        foreach ($materia_prima as $row) {
                            if ($row['Stock'] < $row['Stock_Critico']) {
                                echo "<tr style='background-color: #d4635c;'>
                                        <td><a href='../pages/proveedores.php'>{$row['Nombre']}</a></td>
                                        <td>{$row['Stock']}</td>
                                        <td>{$row['Stock_Critico']}</td>
                                        <td>{$row['Unidad_Medida']}</td>
                                        <td>{$row['Ubicacion']}</td>
                                      </tr>";
                            }
                        }
                        // Luego, mostrar los demás productos
                        foreach ($materia_prima as $row) {
                            if ($row['Stock'] >= $row['Stock_Critico']) {
                                echo "<tr>
                                        <td><a href='../pages/proveedores.php'>{$row['Nombre']}</a></td>
                                        <td>{$row['Stock']}</td>
                                        <td>{$row['Stock_Critico']}</td>
                                        <td>{$row['Unidad_Medida']}</td>
                                        <td>{$row['Ubicacion']}</td>
                                      </tr>";
                            }
                        }
                    } else {
                        echo "<tr><td colspan='5'>No se encontraron resultados</td></tr>";
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
