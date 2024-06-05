<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cantidad_salida = $_POST['cantidad_Salida'];
    $cod_barras = $_POST['cod_barras'];

    $conexion->begin_transaction();

    try {
        // Obtener ID_INVENTARIO de la tabla INVENTARIO usando COD_BARRAS
        $sql = "SELECT ID_INVENTARIO, STOCK, PRECIO FROM INVENTARIO WHERE COD_BARRAS = $cod_barras";
        $result = $conexion->query($sql);

        if ($result === FALSE || $result->num_rows === 0) {
            throw new Exception("Inventario no encontrado para COD_BARRAS: " . $cod_barras);
        }

        $row = $result->fetch_assoc();
        $id_inventario = $row['ID_INVENTARIO'];
        $stock_actual = $row['STOCK'];
        $precio_actual = $row['PRECIO'];

        if ($stock_actual < $cantidad_salida) {
            throw new Exception("Stock insuficiente para realizar la salida.");
        }

        // Obtener los precios de compra y las cantidades en orden FIFO
        $sql = "SELECT ID_TRANSACCION, CANTIDAD_COMPRA, PRECIO_COMPRA 
                FROM TRANSACCION 
                WHERE ID_INVENTARIO = $id_inventario 
                ORDER BY FECHA_COMPRA ASC";
        $result = $conexion->query($sql);

        if ($result === FALSE || $result->num_rows === 0) {
            throw new Exception("No se encontraron transacciones para ID_INVENTARIO: " . $id_inventario);
        }

        $cantidad_restante = $cantidad_salida;
        $total_precio_salida = 0;

        while ($cantidad_restante > 0 && $row = $result->fetch_assoc()) {
            $id_transaccion = $row['ID_TRANSACCION'];
            $cantidad_compra = $row['CANTIDAD_COMPRA'];
            $precio_compra = $row['PRECIO_COMPRA'];

            if ($cantidad_compra >= $cantidad_restante) {
                $total_precio_salida += $cantidad_restante * $precio_compra;
                $cantidad_compra -= $cantidad_restante;
                $cantidad_restante = 0;
            } else {
                $total_precio_salida += $cantidad_compra * $precio_compra;
                $cantidad_restante -= $cantidad_compra;
                $cantidad_compra = 0;
            }

            // Actualizar la cantidad de compra en la tabla TRANSACCION
            $sql_update_transaccion = "UPDATE TRANSACCION SET CANTIDAD_COMPRA = $cantidad_compra WHERE ID_TRANSACCION = $id_transaccion";
            if ($conexion->query($sql_update_transaccion) !== TRUE) {
                throw new Exception("Error al actualizar TRANSACCION: " . $conexion->error);
            }
        }

        if ($cantidad_restante > 0) {
            throw new Exception("No hay suficiente stock para realizar la salida.");
        }

        // Registrar la salida en la tabla SALIDA
        $sql_salida = "INSERT INTO SALIDA (ID_INVENTARIO, CANTIDAD_SALIDA, FECHA_SALIDA)
                       VALUES ($id_inventario, $cantidad_salida, NOW())";
        if ($conexion->query($sql_salida) !== TRUE) {
            throw new Exception("Error al registrar la salida: " . $conexion->error);
        }

        // Calcular el nuevo stock y precio promedio ponderado
        $nuevo_stock = $stock_actual - $cantidad_salida;
        $nuevo_precio = $nuevo_stock > 0 ? (($stock_actual * $precio_actual) - $total_precio_salida) / $nuevo_stock : 0;

        // Actualizar el inventario
        $sql_update_inventario = "UPDATE INVENTARIO SET STOCK = $nuevo_stock, PRECIO = $nuevo_precio WHERE ID_INVENTARIO = $id_inventario";
        if ($conexion->query($sql_update_inventario) !== TRUE) {
            throw new Exception("Error al actualizar el inventario: " . $conexion->error);
        }

        $conexion->commit();
        echo "<p>Salida registrada y el inventario actualizado exitosamente.</p>";
    } catch (Exception $e) {
        $conexion->rollback();
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }

    $conexion->close();
}
?>
