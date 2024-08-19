<?php
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST["usuario"]);
    $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT);

    $conexion = openConnection();

    if ($conexion) {
        $consulta = "INSERT INTO admin (usuario, contrasena) VALUES (?, ?)";
        $stmt = mysqli_prepare($conexion, $consulta);
        mysqli_stmt_bind_param($stmt, "ss", $usuario, $contrasena);

        if (mysqli_stmt_execute($stmt)) {
            echo "Cuenta admin creada exitosamente.";
        } else {
            echo "Error al crear la cuenta: " . mysqli_error($conexion);
        }

        mysqli_stmt_close($stmt);
        closeConnection($conexion);
    } else {
        echo "Error en la conexión a la base de datos.";
    }
}
?>