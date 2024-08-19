<?php
session_start();
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        echo "No se ha iniciado sesión.";
        exit;
    }

    $userId = $_SESSION['user_id'];

    if (isset($_POST['productos'])) {
        $productos = json_decode($_POST['productos'], true);
        if (!$productos) {
            echo "Formato de productos inválido.";
            exit;
        }
    } else {
        echo "No se recibieron productos.";
        exit;
    }

    $conn = openConnection();

    $productosJSON = json_encode($productos);

    $sql = "INSERT INTO pedidos (user_id, productos) VALUES (?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("is", $userId, $productosJSON);

        if ($stmt->execute()) {
            echo "Pedido guardado con éxito.";
        } else {
            echo "Error al guardar el pedido: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error al preparar la declaración: " . $conn->error;
    }

    closeConnection($conn);
}
?>