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

$sql = "DELETE FROM pedidos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $pedidoId);

if ($stmt->execute()) {
    echo "Pedido eliminado con éxito.";
} else {
    echo "Error al eliminar el pedido: " . $stmt->error;
}

$stmt->close();
closeConnection($conn);
?>