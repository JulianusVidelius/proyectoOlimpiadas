<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contrasena"];
    $contacto = $_POST["contacto"];
    $conexion = mysqli_connect("localhost", "root", "", "registros");

    if (!$conexion) {
        die("Error en la conexión a la base de datos: " . mysqli_connect_error());
    }

    $consulta = "INSERT INTO login (usuario, contrasena , contacto) VALUES ('$usuario', '$contraseña', '$contacto')";

    if (mysqli_query($conexion, $consulta)) {
        echo "Registro exitoso. <a href='login.html'>Iniciar sesión</a>";
    } else {
        echo "Error al guardar los datos: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
}
?>