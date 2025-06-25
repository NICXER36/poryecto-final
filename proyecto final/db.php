<?php
$host = "localhost";
$db = "nicolas_huenchullan_db1"; // ⚠️ Este debe ser el nombre exacto de la base de datos que crees en phpMyAdmin del servidor
$user = "nicolas_huenchullan";
$pass = "nicolas_huenchullan2025";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>