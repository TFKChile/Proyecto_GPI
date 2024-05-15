<?php 
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos del proveedor
    $nombre_proveedor = $_POST['nombre_proveedor'];
    $telefono = $_POST['telefono'];
    $mail = $_POST['mail'];

    // Datos de la materia prima
    $cod_barras = $_POST['cod_barras'];
    $nombre_materia_prima = $_POST['nombre_materia_prima'];
    $unidad_medida = $_POST['unidad_medida'];
    $stock_critico = $_POST['stock_critico'];
    $ubicacion = $_POST['ubicacion'];

    // Insertar datos en la tabla Proveedor
    $sql_proveedor = "INSERT INTO Proveedor ( Nombre, Telefono, Mail) VALUES ('$nombre_proveedor', '$telefono', '$mail')";

    if ($conexion->query($sql_proveedor) === TRUE) {
        $id_proveedor = $conexion->insert_id; // Obtener el ID del proveedor insertado

        // Insertar datos en la tabla Materia_Prima
        $sql_materia_prima = "INSERT INTO Materia_Prima (Cod_Barras, Nombre, Unidad_Medida, Stock, Stock_Critico, Ubicacion) VALUES ('$cod_barras','$nombre_materia_prima', '$unidad_medida', 0, '$stock_critico', '$ubicacion')";

        if ($conexion->query($sql_materia_prima) === TRUE) {
            echo "Datos insertados correctamente en Proveedor y Materia_Prima";
        } else {
            echo "Error al insertar datos en Materia_Prima: " . $conexion->error;
        }
    } else {
        echo "Error al insertar datos en Proveedor: " . $conexion->error;
    }

    $conexion->close();
}
?>