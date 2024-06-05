<?php
include '../includes/conexion.php';  // Importa el archivo de conexión

// Consulta SQL para obtener los datos con el último precio de transacción
$sql = "SELECT mp.COD_BARRAS, mp.NOMBRE AS Nombre, umi.NOMBRE_UNIDAD_MEDIDA AS Unidad_Medida, ump.NOMBRE_PACK AS Unidad_Medida_Pack, ump.CANTIDAD_PACK,
               CONCAT('Piso ', p.PISO) AS Ubicacion_Piso, mu.NOMBRE_MUEBLE AS Ubicacion_Mueble, r.NOMBRE_REPISA AS Ubicacion_Repisa,
               inv.STOCK AS Stock, inv.STOCK_MINIMO AS Stock_Critico, COALESCE(trans.PRECIO_COMPRA, inv.PRECIO) AS Precio
        FROM MATERIA_PRIMA mp
        JOIN UNIDAD_MEDIDA_INDIVIDUAL umi ON mp.ID_UNIDAD_MEDIDA_INDIVIDUAL = umi.ID_UNIDAD_MEDIDA_INDIVIDUAL
        JOIN UNIDAD_MEDIDA_PACK ump ON umi.ID_UNIDAD_MEDIDA_PACK = ump.ID_UNIDAD_MEDIDA_PACK  
        JOIN UBICACION u ON mp.ID_UBICACION = u.ID_UBICACION
        JOIN PISO p ON u.ID_PISO = p.ID_PISO
        JOIN MUEBLE mu ON u.ID_MUEBLE = mu.ID_MUEBLE
        JOIN REPISA r ON u.ID_REPISA = r.ID_REPISA
        JOIN INVENTARIO inv ON mp.COD_BARRAS = inv.COD_BARRAS
        LEFT JOIN (
            SELECT ID_INVENTARIO, PRECIO_COMPRA
            FROM TRANSACCION
            WHERE (ID_INVENTARIO, FECHA_COMPRA) IN (
                SELECT ID_INVENTARIO, MAX(FECHA_COMPRA)
                FROM TRANSACCION
                GROUP BY ID_INVENTARIO
            )
        ) trans ON inv.ID_INVENTARIO = trans.ID_INVENTARIO";

$result = $conexion->query($sql);

$materia_prima = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $row['Stock_Unidad'] = $row['Stock'] * $row['CANTIDAD_PACK'];
        $row['Stock_Critico_Unidad'] = $row['Stock_Critico'] * $row['CANTIDAD_PACK'];
        $row['Precio_Unidad'] = $row['Precio'] / $row['CANTIDAD_PACK'];
        $materia_prima[] = $row;
    }
}

$conexion->close();
?>
