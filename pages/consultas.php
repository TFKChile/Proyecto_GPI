<?php include '../includes/Consulta_Materia_Prima.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Materia Prima</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/Consultas.css">
</head>
<body>
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
            if ($materia_prima) {
                foreach ($materia_prima as $row) {
                    echo "<tr>
                            <td>{$row['Nombre']}</td>
                            <td>{$row['Stock']}</td>
                            <td>{$row['Stock_Critico']}</td>
                            <td>{$row['Unidad_Medida']}</td>
                            <td>{$row['Ubicacion']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No se encontraron resultados</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
