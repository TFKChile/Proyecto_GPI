<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cantidad_Salida = $_POST['cantidad_Salida'];
    $cod_barras = $_POST['cod_barras'];

    $conexion->begin_transaction();

    try {
        $sql = "INSERT INTO salida (Cod_Barras, Precio_Salida, Cantidad_Salida)
                SELECT $cod_barras, 10,
                    (SELECT Precio_Compra 
                    FROM transaccion 
                    WHERE Cod_Barras = $cod_barras 
                    ORDER BY Fecha_Compra ASC 
                    LIMIT 1);";
        if ($conexion->query($sql) !== TRUE) {
            throw new Exception("Error al registrar la transacción: " . $conexion->error);
        }

        $id_salida = $conexion->insert_id; 
        $sql_precio_salida = "SELECT Precio_Salida FROM salida WHERE Id_Salida = $id_salida";
        $result = $conexion->query($sql_precio_salida);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $precio_salida = $row['Precio_Salida'];
        

        $sql = "SELECT Stock, Precio FROM Materia_Prima WHERE Cod_Barras = $cod_barras";
        $result = $conexion->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stock_actual = $row['Stock'];
            $precio_actual = $row['Precio'];

            $nuevo_stock = $stock_actual - $cantidad_Salida;
            $nuevo_precio = (($stock_actual * $precio_actual) - ($cantidad_Salida * $precio_salida)) / $nuevo_stock;

            $sql = "UPDATE Materia_Prima 
                    SET Stock = $nuevo_stock, Precio = $nuevo_precio 
                    WHERE Cod_Barras = $cod_barras";
            if ($conexion->query($sql) !== TRUE) {
                throw new Exception("Error al actualizar Materia_Prima: " . $conexion->error);
            }

            $conexion->commit();
            echo "<p>salida registrada</p>";
        }} else {
            throw new Exception("Materia_Prima no encontrada con Cod_Barras: " . $cod_barras);
        }
    } catch (Exception $e) {
        $conexion->rollback();
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }

    $conexion->close();
}
?>
