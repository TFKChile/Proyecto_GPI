<?php
include '../includes/conexion.php';  // Importa el archivo de conexión

if (isset($_GET['cod_barras'])) {
    $cod_barras = $_GET['cod_barras'];

    // Consulta SQL para obtener los datos del proveedor y de la marca
    $sql = "SELECT 
    p.NOMBRE AS Proveedor, p.TELEFONO, p.MAIL, pr.DETALLE, m.NOMBRE_MARCA AS Marca
    FROM 
        PROVEEDOR p
    JOIN 
        PROVEE pr ON p.ID_PROVEEDOR = pr.ID_PROVEEDOR
    JOIN 
        MARCA m ON pr.ID_MARCA = m.ID_MARCA
    WHERE 
        pr.COD_BARRAS = ?;
    ";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $cod_barras);
    $stmt->execute();
    $result = $stmt->get_result();

    $proveedores = [];
    while ($row = $result->fetch_assoc()) {
        $proveedores[] = $row;
    }

    $stmt->close();
}

$conexion->close();
?>