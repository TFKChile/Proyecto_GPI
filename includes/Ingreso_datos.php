<?php 
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre_proveedor = $_POST['nombre_proveedor'];
    $telefono = $_POST['telefono'];
    $mail = $_POST['mail'];

    $cod_barras = $_POST['cod_barras'];
    $nombre_materia_prima = $_POST['nombre_materia_prima'];
    $unidad_medida_individual = $_POST['unidad_medida_individual'];
    $unidad_medida_pack = $_POST['unidad_medida_pack'];
    $cantidad_pack = $_POST['cantidad_pack'];
    $stock_critico = $_POST['stock_critico'];
    $ubicacion_piso = $_POST['ubicacion_piso'];
    $ubicacion_mueble = $_POST['ubicacion_mueble'];
    $ubicacion_repisa = $_POST['ubicacion_repisa'];
    $marca = $_POST['marca'];
    $detalle = $_POST['detalle'];

    // Insertar en tabla Proveedor
    $sql_proveedor = "INSERT INTO Proveedor (Nombre, Telefono, Mail) VALUES ('$nombre_proveedor', '$telefono', '$mail')";
    if ($conexion->query($sql_proveedor) === TRUE) {
        $id_proveedor = $conexion->insert_id; 

        // Insertar en tabla Marca
        $sql_marca = "INSERT INTO Marca (Nombre_Marca) VALUES ('$marca')";
        if ($conexion->query($sql_marca) === TRUE) {
            $id_marca = $conexion->insert_id;

            // Insertar en tabla Unidad_Medida_Pack
            $sql_ump = "INSERT INTO Unidad_Medida_Pack (Nombre_Pack, Cantidad_Pack) VALUES ('$unidad_medida_pack', '$cantidad_pack')";
            if ($conexion->query($sql_ump) === TRUE) {
                $id_ump = $conexion->insert_id;

                // Insertar en tabla Unidad_Medida_Individual
                $sql_umi = "INSERT INTO Unidad_Medida_Individual (Nombre_Unidad_Medida, Id_Unidad_Medida_Pack) VALUES ('$unidad_medida_individual', '$id_ump')";
                if ($conexion->query($sql_umi) === TRUE) {
                    $id_umi = $conexion->insert_id;

                    // Insertar en tabla Piso
                    $sql_piso = "INSERT INTO Piso (Piso) VALUES ('$ubicacion_piso')";
                    if ($conexion->query($sql_piso) === TRUE) {
                        $id_piso = $conexion->insert_id;

                        // Insertar en tabla Mueble
                        $sql_mueble = "INSERT INTO Mueble (Nombre_Mueble) VALUES ('$ubicacion_mueble')";
                        if ($conexion->query($sql_mueble) === TRUE) {
                            $id_mueble = $conexion->insert_id;

                            // Insertar en tabla Repisa
                            $sql_repisa = "INSERT INTO Repisa (Nombre_Repisa) VALUES ('$ubicacion_repisa')";
                            if ($conexion->query($sql_repisa) === TRUE) {
                                $id_repisa = $conexion->insert_id;

                                // Insertar en tabla Ubicacion
                                $sql_ubicacion = "INSERT INTO Ubicacion (Id_Repisa, Id_Mueble, Id_Piso) VALUES ('$id_repisa', '$id_mueble', '$id_piso')";
                                if ($conexion->query($sql_ubicacion) === TRUE) {
                                    $id_ubicacion = $conexion->insert_id;

                                    // Insertar en tabla Materia_Prima
                                    $sql_materia_prima = "INSERT INTO Materia_Prima (Cod_Barras, Nombre, Id_Unidad_Medida_Individual, Id_Ubicacion, Id_Marca) VALUES ('$cod_barras','$nombre_materia_prima', '$id_umi', '$id_ubicacion', '$id_marca')";
                                    if ($conexion->query($sql_materia_prima) === TRUE) {
                                        $id_materia_prima = $conexion->insert_id;

                                        // Insertar en tabla Provee
                                        $sql_provee = "INSERT INTO Provee (Detalle, Id_Proveedor, Cod_Barras) VALUES ('$detalle', '$id_proveedor', '$cod_barras')";
                                        if ($conexion->query($sql_provee) === TRUE) {
                                           
                                            $sql_inventario = "INSERT INTO INVENTARIO (COD_BARRAS, STOCK, stock_minimo) VALUES ('$cod_barras', 0, '$stock_critico')";
                                            if ($conexion->query($sql_inventario) === TRUE) {
                                                echo "Datos insertados correctamente en todas las tablas relacionadas";
                                            } else {
                                                echo "Error al insertar datos en INVENTARIO: " . $conexion->error;
                                            }
                                        } else {
                                            echo "Error al insertar datos en Provee: " . $conexion->error;
                                        }
                                        
                                    } else {
                                        echo "Error al insertar datos en Materia_Prima: " . $conexion->error;
                                    }
                                } else {
                                    echo "Error al insertar datos en Ubicacion: " . $conexion->error;
                                }
                            } else {
                                echo "Error al insertar datos en Repisa: " . $conexion->error;
                            }
                        } else {
                            echo "Error al insertar datos en Mueble: " . $conexion->error;
                        }
                    } else {
                        echo "Error al insertar datos en Piso: " . $conexion->error;
                    }
                } else {
                    echo "Error al insertar datos en Unidad_Medida_Individual: " . $conexion->error;
                }
            } else {
                echo "Error al insertar datos en Unidad_Medida_Pack: " . $conexion->error;
            }
        } else {
            echo "Error al insertar datos en Marca: " . $conexion->error;
        }
    } else {
        echo "Error al insertar datos en Proveedor: " . $conexion->error;
    }

    $conexion->close();
}
?>
