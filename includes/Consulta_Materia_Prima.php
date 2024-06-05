<?php
include '../includes/conexion.php';  // Importa el archivo de conexión

// Consulta SQL para obtener los datos
$sql = "SELECT mp.COD_BARRAS, mp.NOMBRE AS Nombre, umi.NOMBRE_UNIDAD_MEDIDA AS Unidad_Medida, m.NOMBRE_MARCA AS Marca, 
               CONCAT('Piso ', p.PISO) AS Ubicacion_Piso, mu.NOMBRE_MUEBLE AS Ubicacion_Mueble, r.NOMBRE_REPISA AS Ubicacion_Repisa,
               inv.STOCK AS Stock, inv.STOCK_MINIMO AS Stock_Critico, inv.PRECIO AS Precio
        FROM MATERIA_PRIMA mp
        JOIN UNIDAD_MEDIDA_INDIVIDUAL umi ON mp.ID_UNIDAD_MEDIDA_INDIVIDUAL = umi.ID_UNIDAD_MEDIDA_INDIVIDUAL
        JOIN MARCA m ON mp.ID_MARCA = m.ID_MARCA
        JOIN UBICACION u ON mp.ID_UBICACION = u.ID_UBICACION
        JOIN PISO p ON u.ID_PISO = p.ID_PISO
        JOIN MUEBLE mu ON u.ID_MUEBLE = mu.ID_MUEBLE
        JOIN REPISA r ON u.ID_REPISA = r.ID_REPISA
        JOIN INVENTARIO inv ON mp.COD_BARRAS = inv.COD_BARRAS";

$result = $conexion->query($sql);

$materia_prima = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $materia_prima[] = $row;
    }
}

$conexion->close();
?>
