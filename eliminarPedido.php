<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo "No se ha iniciado sesión.";
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID de pedido no proporcionado.";
    exit;
}

$userId = $_SESSION['user_id'];
$pedidoId = intval($_GET['id']);
$conn = openConnection();

$sql = "DELETE FROM pedidos WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $pedidoId, $userId);

if ($stmt->execute()) {
    echo "Pedido eliminado con éxito.";
} else {
    echo "Error al eliminar el pedido: " . $stmt->error;
}

$stmt->close();
closeConnection($conn);
?>