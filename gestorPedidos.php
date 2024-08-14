<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION['usuario_id'];
    $productos = $_POST["productos"];

    $conexion = mysqli_connect("localhost", "root", "", "registros");

    if (!$conexion) {
        die("Error en la conexión a la base de datos: " . mysqli_connect_error());
    }

    // Calcular el total
    $total = 0;
    foreach ($productos as $producto) {
        // Verifica que las claves existen antes de usarlas
        if (isset($producto['precio']) && isset($producto['cantidad'])) {
            $total += $producto['precio'] * $producto['cantidad'];
        }
    }

    // Insertar el pedido
    $consultaPedido = "INSERT INTO pedidos (usuario_id, estado, total) VALUES ('$usuario_id', 'pendiente', '$total')";

    if (mysqli_query($conexion, $consultaPedido)) {
        $pedido_id = mysqli_insert_id($conexion);

        // Insertar los detalles del pedido
        foreach ($productos as $producto) {
            // Verifica que las claves existen antes de usarlas
            if (isset($producto['nombre_producto']) && isset($producto['cantidad']) && isset($producto['precio'])) {
                $nombre_producto = $producto['nombre_producto'];
                $cantidad = $producto['cantidad'];
                $precio_unitario = $producto['precio'];

                $consultaDetalle = "INSERT INTO detalles_pedidos (pedido_id, nombre_producto, cantidad, precio_unitario) VALUES ('$pedido_id', '$nombre_producto', '$cantidad', '$precio_unitario')";
                if (!mysqli_query($conexion, $consultaDetalle)) {
                    echo "Error al guardar los detalles del pedido: " . mysqli_error($conexion);
                    mysqli_close($conexion);
                    exit;
                }
            } else {
                echo "Error: Falta información del producto.";
                mysqli_close($conexion);
                exit;
            }
        }

        echo "Pedido realizado exitosamente.";
    } else {
        echo "Error al guardar el pedido: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
}
?>



