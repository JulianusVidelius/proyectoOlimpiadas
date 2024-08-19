<?php
session_start();
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST["usuario"]);
    $contrasena = $_POST["contrasena"];

    $conexion = openConnection();

    if ($conexion) {
        $consulta = "SELECT * FROM admin WHERE usuario = ?";
        $stmt = mysqli_prepare($conexion, $consulta);
        mysqli_stmt_bind_param($stmt, "s", $usuario);

        if (mysqli_stmt_execute($stmt)) {
            $resultado = mysqli_stmt_get_result($stmt);
            $fila = mysqli_fetch_assoc($resultado);

            if ($fila && password_verify($contrasena, $fila['contrasena'])) {
                $_SESSION["admin_id"] = $fila['id'];
                $_SESSION["admin_usuario"] = $fila['usuario'];
                echo "Inicio de sesión exitoso. <a href='adminPanel.html'>Ir al panel</a>";
            } else {
                echo "Usuario o contraseña incorrectos.";
            }
        } else {
            echo "Error en la consulta: " . mysqli_error($conexion);
        }

        mysqli_stmt_close($stmt);
        closeConnection($conexion);
    } else {
        echo "Error en la conexión a la base de datos.";
    }
}
?>