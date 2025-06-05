<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "mi_basededatos"; // Cámbialo por el nombre de tu base de datos real

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
