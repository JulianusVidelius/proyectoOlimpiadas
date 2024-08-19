<?php
require 'db_connection.php'; // Incluye la conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim(htmlspecialchars($_POST["nombre"]));
    $apellidos = trim(htmlspecialchars($_POST["apellidos"]));
    $contacto = trim(htmlspecialchars($_POST["contacto"]));
    $usuario = trim(htmlspecialchars($_POST["usuario"]));
    $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT);

    // Crear la conexión
    $conexion = openConnection();

    if ($conexion) {
        $consulta = "INSERT INTO login (nombre, apellidos, contacto, usuario, contrasena) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $consulta);
        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $apellidos, $contacto, $usuario, $contrasena);

        if (mysqli_stmt_execute($stmt)) {
            echo "Registro exitoso. <a href='login.html'>Iniciar sesión</a>";
        } else {
            echo "Error al guardar el registro: " . mysqli_error($conexion);
        }

        mysqli_stmt_close($stmt);
        closeConnection($conexion);
    } else {
        echo "Error en la conexión a la base de datos.";
    }
}
?>