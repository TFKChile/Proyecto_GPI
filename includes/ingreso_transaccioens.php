<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cantidad_compra = $_POST['cantidad_compra'];
    $precio_compra = $_POST['precio_compra'];
    $cod_barras = $_POST['cod_barras'];

    $conexion->begin_transaction();

    try {
        $sql = "INSERT INTO Transaccion (Cantidad_Compra, Precio_Compra, Cod_Barras) 
                VALUES ($cantidad_compra, $precio_compra, $cod_barras)";
        if ($conexion->query($sql) !== TRUE) {
            throw new Exception("Error al registrar la transacción: " . $conexion->error);
        }

        $sql = "SELECT Stock, Precio FROM Materia_Prima WHERE Cod_Barras = $cod_barras";
        $result = $conexion->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stock_actual = $row['Stock'];
            $precio_actual = $row['Precio'];

            $nuevo_stock = $stock_actual + $cantidad_compra;
            $nuevo_precio = (($stock_actual * $precio_actual) + ($cantidad_compra * $precio_compra)) / $nuevo_stock;

            $sql = "UPDATE Materia_Prima 
                    SET Stock = $nuevo_stock, Precio = $nuevo_precio 
                    WHERE Cod_Barras = $cod_barras";
            if ($conexion->query($sql) !== TRUE) {
                throw new Exception("Error al actualizar Materia_Prima: " . $conexion->error);
            }

            $conexion->commit();
            echo "<p>Transacción registrada y Materia_Prima actualizada exitosamente</p>";
        } else {
            throw new Exception("Materia_Prima no encontrada con Cod_Barras: " . $cod_barras);
        }
    } catch (Exception $e) {
        $conexion->rollback();
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }

    $conexion->close();
}
?>
