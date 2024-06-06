<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cantidad_Salida']) && isset($_POST['cod_barras'])) {
        $cantidad_salida = $_POST['cantidad_Salida'];
        $cod_barras = $_POST['cod_barras'];

        // Iniciar transacción
        $conexion->begin_transaction();

        try {
            // Obtener ID_INVENTARIO, STOCK y PRECIO de la tabla INVENTARIO usando COD_BARRAS
            $sql = "SELECT ID_INVENTARIO, STOCK, PRECIO FROM INVENTARIO WHERE COD_BARRAS = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("i", $cod_barras);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result === FALSE || $result->num_rows === 0) {
                throw new Exception("Inventario no encontrado para COD_BARRAS: " . $cod_barras);
            }

            $row = $result->fetch_assoc();
            $id_inventario = $row['ID_INVENTARIO'];
            $stock_actual = $row['STOCK']; // Aquí se obtiene el stock actual del inventario
            $precio_actual = $row['PRECIO'];

            // Verificar si hay suficiente stock
            if ($stock_actual < $cantidad_salida) {
                throw new Exception("Stock insuficiente para realizar la salida.");
            }

            // Obtener los precios de compra y las cantidades en orden FIFO
            $sql = "SELECT ID_TRANSACCION, CANTIDAD_COMPRA, PRECIO_COMPRA 
                    FROM TRANSACCION 
                    WHERE ID_INVENTARIO = ? 
                    ORDER BY FECHA_COMPRA ASC";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("i", $id_inventario);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result === FALSE || $result->num_rows === 0) {
                throw new Exception("No se encontraron transacciones para ID_INVENTARIO: " . $id_inventario);
            }

            $cantidad_restante = $cantidad_salida;
            $total_precio_salida = 0;

            // Procesar las transacciones en orden FIFO
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
                $sql_update_transaccion = "UPDATE TRANSACCION SET CANTIDAD_COMPRA = ? WHERE ID_TRANSACCION = ?";
                $stmt_update = $conexion->prepare($sql_update_transaccion);
                $stmt_update->bind_param("ii", $cantidad_compra, $id_transaccion);
                if ($stmt_update->execute() !== TRUE) {
                    throw new Exception("Error al actualizar TRANSACCION: " . $conexion->error);
                }
            }

            if ($cantidad_restante > 0) {
                throw new Exception("No hay suficiente stock para realizar la salida.");
            }

            // Registrar la salida en la tabla SALIDA
            $sql_salida = "INSERT INTO SALIDA (ID_INVENTARIO, CANTIDAD_SALIDA, FECHA_SALIDA)
                           VALUES (?, ?, NOW())";
            $stmt_salida = $conexion->prepare($sql_salida);
            $stmt_salida->bind_param("ii", $id_inventario, $cantidad_salida);
            if ($stmt_salida->execute() !== TRUE) {
                throw new Exception("Error al registrar la salida: " . $conexion->error);
            }

            // Calcular el nuevo stock y precio promedio ponderado
            $nuevo_stock = $stock_actual - $cantidad_salida;
            $nuevo_precio = $nuevo_stock > 0 ? (($stock_actual * $precio_actual) - $total_precio_salida) / $nuevo_stock : 0;

            // Actualizar el inventario
            $sql_update_inventario = "UPDATE INVENTARIO SET STOCK = ?, PRECIO = ? WHERE ID_INVENTARIO = ?";
            $stmt_update_inventario = $conexion->prepare($sql_update_inventario);
            $stmt_update_inventario->bind_param("idi", $nuevo_stock, $nuevo_precio, $id_inventario);
            if ($stmt_update_inventario->execute() !== TRUE) {
                throw new Exception("Error al actualizar el inventario: " . $conexion->error);
            }

            // Confirmar transacción
            $conexion->commit();
            echo "<p>Salida registrada y el inventario actualizado exitosamente.</p>";
        } catch (Exception $e) {
            // Revertir transacción
            $conexion->rollback();
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }

        // Cerrar conexión
        $conexion->close();
    } else {
        echo "<p>Error: Los campos 'cantidad_salida' y 'cod_barras' son obligatorios.</p>";
    }
}
?>
