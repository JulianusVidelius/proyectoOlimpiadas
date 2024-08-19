<?php
session_start();

$response = array("sesionIniciada" => false);

if (isset($_SESSION['user_id'])) {
    $response["sesionIniciada"] = true;
}

echo json_encode($response);
?>