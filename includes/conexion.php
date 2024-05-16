<?php
    $Servername = "localhost";
    $Username = "root";
    $Password = "";
    $database = "GPI";

    $conexion = new mysqli($Servername, $Username, $Password, $database);

    if($conexion->connect_error){
        die("conexion fallida: ".$conexion->connect_error);
    }
    ?>
