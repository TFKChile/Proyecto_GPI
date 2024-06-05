<?php
include '../includes/consulta_proveedor.php';
include '../templates/menu.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos del Proveedor</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/Consultas.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="table-container">
            <h2>Datos del Proveedor</h2>
            <?php if (!empty($proveedores)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Proveedor</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Tiempo de Entrega</th>
                            <th>Marca</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($proveedores as $proveedor): ?>
                            <tr>
                                <td><?php echo $proveedor['Proveedor']; ?></td>
                                <td><?php echo $proveedor['TELEFONO']; ?></td>
                                <td><?php echo $proveedor['MAIL']; ?></td>
                                <td><?php echo $proveedor['DETALLE']; ?></td>
                                <td><?php echo $proveedor['Marca']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No se encontraron datos del proveedor.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
