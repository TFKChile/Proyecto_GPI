<?php
include 'conexion.php';

$sql = "SELECT Nombre, Stock, Stock_Critico, Unidad_Medida, Ubicacion FROM Materia_Prima";
$result = $conexion->query($sql);

$materia_prima = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $materia_prima[] = $row;
    }
} else {
    $materia_prima = null;
}
$conexion->close();
?>
