
<?php
header('Content-Type: application/json');
include 'db.php';

$sql = "SELECT * FROM proyectos";
$resultado = $conn->query($sql);

$proyectos = [];

if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        $proyectos[] = $fila;
    }
}

echo json_encode($proyectos);
?>