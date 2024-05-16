<?php 
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre_proveedor = $_POST['nombre_proveedor'];
    $telefono = $_POST['telefono'];
    $mail = $_POST['mail'];

    $cod_barras = $_POST['cod_barras'];
    $nombre_materia_prima = $_POST['nombre_materia_prima'];
    $unidad_medida = $_POST['unidad_medida'];
    $stock_critico = $_POST['stock_critico'];
    $ubicacion = $_POST['ubicacion'];

    $sql_proveedor = "INSERT INTO Proveedor ( Nombre, Telefono, Mail) VALUES ('$nombre_proveedor', '$telefono', '$mail')";

    if ($conexion->query($sql_proveedor) === TRUE) {
        $id_proveedor = $conexion->insert_id; 

        $sql_materia_prima = "INSERT INTO Materia_Prima (Cod_Barras, Nombre, Unidad_Medida, Stock, Stock_Critico, Ubicacion, Id_Proveedor) VALUES ('$cod_barras','$nombre_materia_prima', '$unidad_medida', 0, '$stock_critico', '$ubicacion', '$id_proveedor')";

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