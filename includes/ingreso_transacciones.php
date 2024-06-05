<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cantidad_compra = $_POST['cantidad_compra'];
    $precio_compra = $_POST['precio_compra'];
    $cod_barras = $_POST['cod_barras'];

    $conexion->begin_transaction();

    try {
        // Verificar si la materia prima ya está en el inventario
        $sql = "SELECT ID_INVENTARIO, STOCK FROM INVENTARIO WHERE COD_BARRAS = $cod_barras";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            // Materia prima existe en inventario
            $row = $result->fetch_assoc();
            $id_inventario = $row['ID_INVENTARIO'];
            $stock_actual = $row['STOCK'];

            // Calcular el nuevo stock
            $nuevo_stock = $stock_actual + $cantidad_compra;

            // Actualizar los datos en INVENTARIO
            $sql = "UPDATE INVENTARIO 
                    SET STOCK = $nuevo_stock 
                    WHERE ID_INVENTARIO = $id_inventario";
            if ($conexion->query($sql) !== TRUE) {
                throw new Exception("Error al actualizar INVENTARIO: " . $conexion->error);
            }
        } else {
            // Materia prima no existe en inventario, agregarla
            $sql = "INSERT INTO INVENTARIO (PRECIO, STOCK, STOCK_MINIMO, COD_BARRAS) 
                    VALUES ($precio_compra, $cantidad_compra, 0, $cod_barras)";
            if ($conexion->query($sql) !== TRUE) {
                throw new Exception("Error al insertar en INVENTARIO: " . $conexion->error);
            }
            $id_inventario = $conexion->insert_id;
        }

        // Insertar en la tabla TRANSACCION
        $sql = "INSERT INTO TRANSACCION (CANTIDAD_COMPRA, PRECIO_COMPRA, ID_INVENTARIO) 
                VALUES ($cantidad_compra, $precio_compra, $id_inventario)";
        if ($conexion->query($sql) !== TRUE) {
            throw new Exception("Error al registrar la transacción: " . $conexion->error);
        }

        $conexion->commit();
        echo "<p>Transacción registrada y INVENTARIO actualizado exitosamente</p>";
    } catch (Exception $e) {
        $conexion->rollback();
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }

    $conexion->close();
}
?>
