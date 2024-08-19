<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["error" => "No se ha iniciado sesión como admin."]);
    exit;
}

$conn = openConnection();

$sql = "SELECT id, productos FROM pedidos";
$result = $conn->query($sql);

$pedidos = [];
while ($row = $result->fetch_assoc()) {
    $pedidos[] = $row;
}

closeConnection($conn);

echo json_encode(["pedidos" => $pedidos]);
?>