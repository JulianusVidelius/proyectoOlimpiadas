<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['admin_id'])) {
    echo "No se ha iniciado sesión como admin.";
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID de pedido no proporcionado.";
    exit;
}

$pedidoId = intval($_GET['id']);
$conn = openConnection();

if (!$conn) {
    echo "Error en la conexión a la base de datos.";
    exit;
}

$sql = "UPDATE pedidos SET estado = 'entregado' WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Error en la preparación de la consulta: " . $conn->error;
    exit;
}

$stmt->bind_param("i", $pedidoId);

if ($stmt->execute()) {
    echo "Pedido marcado como entregado.";
} else {
    echo "Error al marcar el pedido como entregado: " . $stmt->error;
}

$stmt->close();
closeConnection($conn);
?>