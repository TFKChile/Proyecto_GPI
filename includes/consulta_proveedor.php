<?php
include '../includes/conexion.php';  // Importa el archivo de conexión

if (isset($_GET['cod_barras'])) {
    $cod_barras = $_GET['cod_barras'];

    // Consulta SQL para obtener los datos del proveedor
    $sql = "SELECT p.NOMBRE AS Proveedor, p.TELEFONO, p.MAIL, pr.TIEMPO_ENTREGA
            FROM PROVEEDOR p
            JOIN PROVEE pr ON p.ID_PROVEEDOR = pr.ID_PROVEEDOR
            WHERE pr.COD_BARRAS = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $cod_barras);
    $stmt->execute();
    $result = $stmt->get_result();

    $proveedor = $result->fetch_assoc();

    $stmt->close();
}

$conexion->close();
?>
