<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contrasena"];
    
    $conexion = mysqli_connect("localhost", "root", "", "registros");

    if (!$conexion) {
        die("Error en la conexión a la base de datos: " . mysqli_connect_error());
    }

    $consulta = "SELECT id FROM login WHERE usuario = '$usuario' AND contrasena = '$contraseña'";
    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado) == 1) {
        $fila = mysqli_fetch_assoc($resultado);
        $_SESSION['usuario_id'] = $fila['id'];
        header("Location: realizarPedido.html");
    } else {
        echo "Usuario o contraseña incorrectos.";
    }

    mysqli_close($conexion);
}
?>
