<?php
function openConnection() {
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "registros";

    $conexion = new mysqli($host, $user, $password, $dbname);

    if ($conexion->connect_error) {
        die("Error en la conexión a la base de datos: " . $conexion->connect_error);
    }

    return $conexion;
}

function closeConnection($conexion) {
    $conexion->close();
}
?>